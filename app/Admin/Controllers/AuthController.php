<?php

namespace App\Admin\Controllers;

//use Encore\Admin\Controllers\AuthController as BaseAuthController;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;




use Encore\Admin\Auth\Database\OperationLog as OperationLogModel; //ebm
use Illuminate\Support\Facades\DB; // ebm
use Illuminate\Support\Carbon; //ebm
use Illuminate\Foundation\Auth\ThrottlesLogins; //ebm

//class AuthController extends BaseAuthController
class AuthController 
{

   // ebm
	use ThrottlesLogins;

	protected $maxAttempts=3;
	protected $decayMinutes=1;

	protected function hasTooManyLoginAttempts(Request $request)
	{
		return $this->limiter()->tooManyAttempts(
			$this->throttleKey($request), $this->maxAttempts(),  $this->decayMinutes()
		);
	}

    /**
     * Show the login page.
     *
     * @return \Illuminate\Contracts\View\Factory|Redirect|\Illuminate\View\View
     */
    public function getLogin()
    {
    	if ($this->guard()->check()) {
    		return redirect($this->redirectPath());
    	}

    	return view('admin::login');
    }


    public function postLogin(Request $request)
    {
    	$credentials = $request->only([$this->username(), 'password']);

        //ebm valida intentos erroneos de acceso y bloquea temporalmente
    	if ($this->hasTooManyLoginAttempts($request)) {
           // queda pendiente determinar si bloquea temporalmente o al usuario en bd.
    		$this->fireLockoutEvent($request);
    		return $this->sendLockoutResponse($request);
    	}

    	/** @var \Illuminate\Validation\Validator $validator */
    	$validator = Validator::make($credentials, [
    		$this->username()   => 'required',
    		'password'          => 'required',
    	]);
		//dump($this->incrementLoginAttempts($request));
		//dd($this->hasTooManyLoginAttempts($request));
    	if ($validator->fails()) {
    		$this->incrementLoginAttempts($request);
    		return back()->withInput()->withErrors($validator);
    	}

    	if ($this->guard()->attempt($credentials)) {
    		return $this->sendLoginResponse($request);
    	}

      $this->incrementLoginAttempts($request);
      return back()->withInput()->withErrors([
          $this->username() => $this->getFailedLoginMessage(),
      ]);

  }

  public function getLogout(Request $request)
  {
   $log = [
  //        'user_id' => Admin::user()->id,
      'path'    => 'Fin de Sesión',
      'method'  => 'Logout',
      'ip'      => $request->getClientIp(),
      'input'   => '{"_pjax":"#pjax-container"}',
  ];
  $this->guard()->logout();

  $request->session()->invalidate();

  return redirect(config('admin.route.prefix'));
}

    /**
     * User setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {
     //ebm
    	return Admin::content(function (Content $content) {
    		$content->header(trans('admin.user_setting'));
    		$form = $this->settingForm();
    		$form->tools(
    			function (Form\Tools $tools) {
    				$tools->disableBackButton();
    				$tools->disableListButton();
    			}
    		);
    		$content->body($form->edit(Admin::user()->id));
    	});

    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
    	return $this->settingForm()->update(Admin::user()->id);
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
    	return Lang::has('auth.failed')
    	? trans('auth.failed')
    	: 'These credentials do not match our records.';
    }

    /**
     * Get the post login redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {

    	if (method_exists($this, 'redirectTo')) {
    		return $this->redirectTo();
    	}
    	return property_exists($this, 'redirectTo') ? $this->redirectTo : config('admin.route.prefix');
    }
    /**
     * Send the response after the user was authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {

      // ebm valida que usuario este activo
    	if($this->guard()->user()->activo == 0){
    		$this->guard()->logout();
    		return back()->withInput()->withErrors([
    			$this->username() => ' Usuario no Activo!!!'
    		]);
    	}

      // ebm actualiza ultima actividad e IP
    	$this->guard()->user()->last_activity=now();
    	$this->guard()->user()->last_ip_adress=$request->getClientIp();
    	$this->guard()->user()->save();
    	admin_toastr(trans('admin.login_successful'));

    	$log = [
    		'user_id' => Admin::user()->id,
    		'path'    => 'Inicio de Sesión',
    		'method'  => 'Login',
    		'ip'      => $request->getClientIp(),
    		'input'   => '{"_pjax":"#pjax-container"}',
    	];



      $request->session()->regenerate();
      // ebm actualiza variables de ambiente de acuerdo al perfil de usuario
      $request->session()->put('activo',$this->guard()->user()->toArray()['activo']);
      $request->session()->put('update_password', $this->guard()->user()->toArray()['update_password']);
      $request->session()->put('empresa_id', $this->guard()->user()->toArray()['empresa_id']);
      $request->session()->put('empresa2_id', $this->guard()->user()->toArray()['empresa2_id']);
      $request->session()->put('admin_tipo_user_id', $this->guard()->user()->toArray()['admin_tipo_user_id']);
      $request->session()->put('admin_tipo_sitio_id', $this->guard()->user()->toArray()['admin_tipo_sitio_id']);
      $request->session()->put('admin_tipo_sitio_id', $this->guard()->user()->toArray()['admin_tipo_sitio_id']);        

      OperationLogModel::create($log);
      //dd(trans('admin.login_successful'));
      // ebm valida que usuario actualice contraseña
      if($this->guard()->user()->update_password == 1){
          return redirect()->route('profile')->withErrors(
             [
                'message'=>'Es necesario Actualizar Contraseña!!!',
                'errors' =>'has-errors',
                'type'   =>'success'
            ]);
      }
      //dd(trans('admin.login_successful'));
      // ebm valida expiración de la contraseña
      $password_updated= DB::table('admin_password_securities')
      ->select('password_updated_at','password_expiry_days')
      ->where('user_id',Admin::user()->id)
      ->first();
      //dump(Admin::user()->id);
      //dd($password_updated);
      $password_expiry_at =Carbon::parse($password_updated->password_updated_at)->addDays($password_updated->password_expiry_days);


      if($password_expiry_at->lessThan(Carbon::now())){
          $this->guard()->logout();
          return back()->withInput()->withErrors([
             $this->username() => ' Tu usaurio ha caducado tienes más de 30 días sin uso, Favor de hablar al HelpDesk!!!'
         ]);
      }else {

      }
     // $this->clearLoginAttempts($request);
      return redirect()->intended($this->redirectPath());

  }
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    protected function username()
    {
    	return 'username';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
    	return Auth::guard('admin');
    }    
}
