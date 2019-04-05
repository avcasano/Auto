@extends('apptelmex.mail.welcome')

@section('content')

	@include('apptelmex.mail.newfeatureStart')

		<h4 class="secondary"><strong>Bienvenido {{$name}} </strong></h4>

    <p>Deberás ingresar con las siguientes credenciales:</p>
		<p>Usuario    : {{$username}}<br>
    Contraseña : {{$password}}<br>
    Dirección : <a href="{{config('app.url')}}">{{config('app.name')}}</a>
    </p>

	@include('apptelmex.mail.newfeatureEnd')

@stop
