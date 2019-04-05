|<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{config('admin.title')}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css") }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/font-awesome/css/font-awesome.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/dist/css/AdminLTE.min.css") }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/iCheck/square/blue.css") }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style type="text/css">
      .login-page, .register-page {
          background:  url('{{config('admin.login_background_image')}}');
          color: #ffffff  !important;
          background-repeat: no-repeat;
          background-position: center;
          background-size: cover;
      }
      .login-box, .register-box {
          margin: 2% auto;
      }
      .login-box-body {
          box-shadow: 0px 0px 50px rgba(0, 0, 0, 0.8);
          background: rgba(255, 255, 255, 0.9);
          color: #666666 !important;
      }
      html, body {
          overflow: hidden;
      }
</style>

</head>
<body class="login-page" >


<div class="login-box" style="margin-left:7% !important">
  <div class="login-logo">
    <a href="{{ admin_base_path('/') }}">
      <img title='{{config('admin.name')}}' src='{{ asset('vendor/apptelmex/img/logo.png')}}' style='max-width: 100%;max-height:170px'/>
    </a>
  </div>
  <!-- /.login-logo -->

  <div class="login-box-body">
    <p class="login-box-msg"><strong>{{Admin::user()->name}}</strong><br></p>
    <form action="{{ route('changePassword') }}" method="post">

      <div class="form-group has-feedback {!! !$errors->has('errors') ?: 'has-error' !!}">
        <input type="password" class="form-control" placeholder="Contraseña actual" name="current-password" value="" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback {!! !$errors->has('errors') ?: 'has-error' !!}">
        <input type="password" class="form-control" placeholder="Nueva Contraseña" name="new-password" value="" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>

      <div class="form-group has-feedback {!! !$errors->has('new-password') ?: 'has-error' !!}">
        <input type="password" class="form-control" placeholder="{{ trans('admin.password_confirmation') }}" name="new-password_confirmation" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
        <div class="row">
          <div class="col-xs-6 col-md-offset-3">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class='fa fa-lock'></i> Actualizar</button>
          </div>
        <div>
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<div  style="margin-left:7% !important">
  <div class="row">
    <br>

    @if($errors->has('username'))
      @foreach($errors->get('username') as $message)
        <p ><i class="fa fa-times-circle-o"></i> {{$message}}</p>
      @endforeach
    @endif
    @if($errors->has('new-password'))
      <p ><i class="fa fa-times-circle-o"></i> {{$errors->get('new-password')[0]}}</p>
        <dl>
          <dt>Su contraseña debe tener:</dt>
          <dd>- Más de 8 caracteres.</dd>
          <dd>- al menos 1 mayúscula y 1 minúscula.</dd>
          <dd>- al menos 1 numéro.</dd>
          <dd>- al menos 1 carácter especial.</dd>
        </dl>
    @endif
    @if($errors->has('message'))
      @foreach($errors->get('message') as $message)
        <p ><i class="fa fa-times-circle-o"></i> {{$message}}</p>
      @endforeach
    @endif
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js")}} "></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js")}}"></script>
<!-- iCheck -->
<script src="{{ admin_asset("/vendor/laravel-admin/AdminLTE/plugins/iCheck/icheck.min.js")}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
