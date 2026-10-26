
@extends('layouts.app')

@section('title','Iniciar sesión')

@section('content')
<section class="card narrow"><form action="{{ route('login.store') }}" method="post">
@csrf
<label>Correo<input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"></label><label>Contraseña<input type="password" name="password" required autocomplete="current-password"></label><button>Ingresar</button></form><p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate como aspirante</a>.</p></section>
@endsection
