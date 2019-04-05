<?php

namespace App\Admin\Controllers\appTelmex\admin;

use Illuminate\Routing\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;

use Encore\Admin\Layout\Row;
use Encore\Admin\Form;
use App\Models\appTelmex\catfin\Empresa;
use App\Models\appTelmex\admin\TipoUser;
use App\Models\appTelmex\admin\TipoSitio;
use Encore\Admin\Auth\Database\Role;
use Encore\Admin\Auth\Database\Permission;
use Illuminate\Support\MessageBag;

use Illuminate\Support\Facades\Validator;
use Encore\Admin\Auth\Database\OperationLog as OperationLogModel; //ebm
use Illuminate\Support\Facades\DB; // ebm
use Illuminate\Support\Carbon; //ebm

use Encore\Admin\Show;
use Illuminate\Http\Request;
use Encore\Admin\Widgets\Table;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

//use Encore\Admin\Form;

//use Encore\Admin\Layout\Column;


//use App\Models\appTelmex\admin\User;
//use App\Models\appTelmex\admin\PasswordHistory;
//use App\Models\appTelmex\admin\PasswordSecurity;
//use App\Models\appTelmex\admin\TipoUser;
//use App\Models\appTelmex\admin\TipoSitio;
//use App\Models\appTelmex\catfin\Empresa;
//use App\Models\appTelmex\catfin\Division;
//use App\Models\appTelmex\catfin\Area;
//use App\Models\appTelmex\catpro\Sitio;


//use Encore\Admin\Auth\Database\Permission;
//use Encore\Admin\Auth\Database\Role;
//use Encore\Admin\Controllers\ModelForm;
//use Encore\Admin\Facades\Admin;
//use Encore\Admin\Form;
//use Encore\Admin\Grid;
//use Encore\Admin\Layout\Column;
//use Encore\Admin\Layout\Content;
//use Encore\Admin\Layout\Row;
//

//use Illuminate\Http\Request;
//use Encore\Admin\Widgets\Table;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\Mail;
//use Illuminate\Support\Facades\Hash;



class UserController extends Controller
{
    use ModelForm;
    protected $pwd = '';
    protected $mailto = '';


    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {

        return Admin::content(function (Content $content) {
            $content->header(trans('admin.administrator'));
            $content->description(trans('admin.list'));
            $content->body($this->grid()->render());

        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
      return Admin::content(function (Content $content) use ($id) {

          $content->header('Editar');
          $content->description('Usuarios');
          $content->row(function(Row $row) use ($id) {
            $row->column(8, $this->form()->edit($id));
          });
      });

    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {

      return Admin::content(function (Content $content) {

          $content->header('Crear');
          $content->description('Usuarios');
          $content->row(function(Row $row) {
            $row->column(8, $this->form());
          });
      });

    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Administrator::grid(function (Grid $grid) {
          $grid->tools->disableRefreshButton();
          $grid->paginate(10);
          $grid->perPages([10, 20, 30, 40, 50]);
          $grid->tools->disableRefreshButton();
          $grid->tools(function (Grid\Tools $tools) {
              $tools->batch(function (Grid\Tools\BatchActions $actions) {
                  $actions->disableDelete();
              });
          });
          $grid->actions(function (Grid\Displayers\Actions $actions) {
              if ($actions->getKey() == 1) {
                  $actions->disableDelete();
              }
          });
          $grid->actions(function (Grid\Displayers\Actions $actions) {
                $actions->disableView();
          });
        //  $grid->id('ID')->sortable();
          $grid->username('Login')->sortable();
          $grid->name('Nombre');
          $grid->apellido_paterno('A. Paterno');
          $grid->apellido_materno('A. Materno');
          $grid->roles(trans('admin.roles'))->pluck('name')->label();
          $grid->created_at(trans('admin.created_at'));
          $grid->updated_at(trans('admin.updated_at'));
          $grid->filter(function (Grid\Filter $filter) {
              $filter->equal('login','Login');
              $filter->equal('username','Nombre');
              $filter->between('created_at','Creado')->datetime();
              $filter->between('updated_at','Actualizado')->datetime();

          });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {

      return Administrator::form(function (Form $form) {
      $form->hidden('password');
      $form->hidden('user_mod_id');
      $form->tab('Identificación', function (Form $form) {
    // Valida username unico al insert o update
          $form->text('username','Login')
            ->rules(function ($form) {
              if (!$id = $form->model()->id){
                return 'unique:admin_users,username';
              }
          });
          $form->select('empresa_id', 'Empresa')
            ->options(Empresa::all()
            ->pluck('empresa', 'id'))
            ->rules(['required']);
          $form->select('empresa2_id', 'Empresa Cat. Mat.')
            ->options(Empresa::all()
            ->pluck('empresa', 'id'));
          $form->text('name','Nombre')
            ->rules(['required']);
          $form->text('apellido_paterno','A. Paterno')
            ->rules(['required']);
          $form->text('apellido_materno','A. Materno');
          $form->email('email','Email')
            ->rules(['required']);
          $form->switch('activo', 'Activo');
        })->tab('Perfil', function (Form $form) {
          $form->select('admin_tipo_user_id', 'Nivel')
            ->options(TipoUser::all()
            ->pluck('tipo_user', 'id'))
            ->rules(['required'])
            ->load('admin_tipo_sitio_id', '/app/admin/api/niveluser');
          $form->select('admin_tipo_sitio_id', 'Alcance')
            ->options(TipoSitio::all()
            ->pluck('tipo_sitio', 'id'));
          $form->multipleSelect('roles', trans('admin.roles'))
            ->options(Role::all()
            ->pluck('name', 'id'));
          $form->multipleSelect('permissions', trans('admin.permissions'))
            ->options(Permission::all()
            ->pluck('name', 'id'));
          $form->switch('update_password', 'Actualizar Password');

        })->tab('Generales', function (Form $form) {
          $form->text('expediente','Expediente')->rules(['required']);
          $form->text('puesto','Puesto')->rules(['required']);
          $form->mobile('telefono','Teléfono');
          $form->text('direccion','Dirección')->rules(['required']);
        })->tab('Actualizaciones', function (Form $form) {
          $form->display('id', 'ID');
          $form->display('created_at','Creado');
          $form->display('updated_at','Actualizado');
          $form->display('detelted_at','Borrado');
          //if(str_contains(URL::current(), 'edit')){
            $form->display('folio_sima','Folio Sima')->rules(['required']);
          //};
        });

        $form->saving(function (Form $form) {
          // valida que sea un update para no actualizar pwd
          $form->user_mod_id =Admin::user()->id;
          if(!$form->model()->exists){
            $this->pwd = str_random(8);
            $form->password = bcrypt($this->pwd);
            $this->mailto = $form->email;
          };

        });
        //dd($form);
        $form->saved(function (Form $form) {
          if($this->pwd!=''){
            $data=[
              'senderName'=> config('admin.name'),
              'name'      =>  $form->name .' '. $form->apellido_paterno .' '. $form->apellido_materno,
              'username'  =>  $form->username,
              'password'  =>  $this->pwd,
              'address'   =>  config('app.url'),
              ];
           dump($data);
            Mail::send('apptelmex.mail.mail', $data, function ($message) {
              $message->from(config('admin.email'), config('admin.name'));
              $message->to($this->mailto)->subject('Credenciales de acceso al sistema '.config('admin.name'));
            });

            $passwordSecurity = PasswordSecurity::create([
                'user_id' => $form->model()->getAttributes()['id'],
                'password_expiry_days' => config('password_expiry'),
                'password_created_at' => now(),
                'password_updated_at' => now(), //'password_updated_at' => Carbon::now(),
            ]);
           dump($passwordSecurity);
           dd($form);
          }
        });
      });
    }

    public function niveluser(Request $request)
    {
      $tipositio = $request->get('q');
      switch ($tipositio) {
          case 1:
          return DB::table('catpro_sitios')
            ->join('admin_sitio_sap', 'catpro_sitios.admin_sitio_sap_id', '=', 'admin_sitio_sap.id')
            ->select(DB::raw("concat(sitio_sap,' :: ',sitio) as text,catpro_sitios.id"))
            ->get();

              //return Sitio::all()->pluck('sitio','id');
          case 2:
            return DB::table('catfin_areas')
              ->join('catfin_divisiones', 'catfin_areas.catfin_division_id', '=', 'catfin_divisiones.id')
              ->select(DB::raw("concat(area,' :: ',division) as text,catfin_areas.id"))
              ->get();

            //  return Area::all()->pluck('area','id');
          case 3:
              return Division::all()->pluck('division','id');
      }
      return response()->json(['id' => '', 'text' => '']);

    }
    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return view
     */

    public function getProfile()
    {
//        return view('apptelmex.profile.change_password');
      return Admin::content(function (Content $content) {
        $content->row(function (Row $row) {
          $row->column(4,'');
          $row->column(4, function (Column $column) {
              $column->append(view('apptelmex.profile.change_password'));
          });
        });
          $content->row('');
        });
    }

    public function changePassword(Request $request){

      if (!(Hash::check($request->get('current-password'), Admin::user()->getattributes()['password']))) {
          // The passwords matches
          //
          return redirect()->back()->withErrors(
            [
              'message'=>'Su contraseña actual no coincide con la contraseña que proporcionó. Inténtalo de nuevo.',
              'errors' =>'has-error',
              'type'   =>'success'
            ]);
      }

      if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
      //Current password and new password are same
        return redirect()->back()->withErrors(
          [
            'username'=>'La nueva contraseña no puede ser igual a su contraseña actual. Por favor, elija una contraseña diferente.',
            'errors' =>'has-error',
            'type'   =>'success'
          ]);
      }

      $validatedData = $request->validate([
      'current-password' => 'required',
      'errors' =>'has-error',
      'new-password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
      //'new-password' => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
      ]);

      //ebm valida historial de contraseñas

      $user = Admin::user();
      $passwordHistories = DB::table('admin_password_histories')
                ->where('user_id', $user->id)
                ->take(config('password_history_num'))
                ->get();
      foreach($passwordHistories as $passwordHistory){
          echo $passwordHistory->password;
          if (Hash::check($request->get('new-password'), $passwordHistory->password)) {
              // The passwords matches
              return redirect()->back()->withErrors(
                [
                  'message'=>'Su nueva contraseña no puede ser la misma que a usado recientemente. Por favor elija una nueva contraseña',
                  'errors' =>'has-error',
                  'type'   =>'success'
                ]);
          }
      }

      //ebm cambia contraseña
      //$user = Admin::user();
      $user->password = bcrypt($request->get('new-password'));
      $user->update_password ='0';
      $user->save();
      //ebm actualiza el historial de password's
      $passwordHistory = PasswordHistory::create([
            'user_id' => $user->id,
            'password' => bcrypt($request->get('new-password'))
        ]);
      //ebm actualiza $password_updated
      $password_updated = PasswordSecurity::where('user_id', $user->id)->update(array('password_updated_at' => now()));

      $request->session()->forget('update_password');
      $request->session()->put('update_password','0');
      admin_toastr('Contraseña actualizada correctamente!!!');
      return redirect(admin_base_path('/'));
    }
}
