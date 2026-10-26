<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>
@yield('title','CRM Aspirantes') - MW Consultores</title><link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body><header class="top"><div class="wrap flex"><a href="{{ route('dashboard') }}" class="brand">CRM <span>Admisiones</span></a>
@auth<nav><a href="{{ route('dashboard') }}">Inicio</a><a href="{{ route('aspirantes.index') }}">Aspirantes</a><a href="{{ route('programas.index') }}">Programas</a></nav><div class="right">{{ auth()->user()->name }} <small>({{ auth()->user()->rol }})</small><form method="post" action="{{ route('logout') }}">
@csrf
<button class="link">Salir</button></form></div>
@endauth
</div></header>
<main class="wrap"><h1>
@yield('title','CRM de aspirantes')
</h1>
@if(session('ok'))
<div class="alert ok">{{ session('ok') }}</div>
@endif
@if($errors->any())
<div class="alert error"><b>Revisa los datos:</b><ul>
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul></div>
@endif
@yield('content')
</main><footer class="wrap foot">Proyecto académico · Laravel 12 / MySQL · MW Consultores</footer></body></html>
