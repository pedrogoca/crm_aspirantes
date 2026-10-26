
@extends('layouts.app')

@section('title','Registro de usuario aspirante')

@section('content')
<section class="card narrow"><form method="post" action="{{ route('register.store') }}">
@csrf
<label>Nombre completo<input name="name" value="{{ old('name') }}" required maxlength="150"></label><label>Correo<input type="email" name="email" value="{{ old('email') }}" required></label><label>Contraseña (mínimo 10 caracteres)<input type="password" name="password" minlength="10" required></label><label>Confirmación<input type="password" name="password_confirmation" required></label><button>Crear cuenta</button></form><p><a href="{{ route('login') }}">Volver a ingresar</a></p></section>
@endsection
