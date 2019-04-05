
<div class="panel panel-primary">
  <!-- /.login-logo -->
  <div class="panel-heading">Actualizar Contraseña</div>
  <div class="panel-body">
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
      <div class="row" style="margin-left:3% !important">
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
      <div class="row">
        <div class="col-xs-6 col-md-offset-3">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-primary btn-block btn-flat"><i class='fa fa-lock'></i> Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
