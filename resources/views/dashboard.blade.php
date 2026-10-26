
@extends('layouts.app')

@section('title','Panel principal')

@section('content')

@if($personal)
<div class="stats">
@foreach($indicadores as $nombre=>$valor)
<article class="card"><small>{{ $nombre }}</small><div class="stat">{{ $valor }}</div></article>
@endforeach
</div><p><a class="btn" href="{{ route('aspirantes.index') }}">Administrar aspirantes</a></p>

@elseif($aspirante)
<div class="card"><h2>Mi solicitud</h2><p>Estado: <b>{{ $aspirante->estatus }}</b></p><a class="btn" href="{{ route('aspirantes.show',$aspirante) }}">Ver expediente</a></div>

@else
<div class="card"><h2>Nueva solicitud de admisión</h2><form method="post" action="{{ route('aspirantes.store') }}">
@csrf
<div class="grid"><label>Programa<select name="id_programa" required><option value="">Seleccionar</option>
@foreach($programas as $p)
<option value="{{ $p->id_programa }}">{{ $p->nombre }} - {{ $p->modalidad }}</option>
@endforeach
</select></label><label>Nombre<input name="nombre" required value="{{ old('nombre') }}"></label><label>Apellido paterno<input name="apellido_paterno" required value="{{ old('apellido_paterno') }}"></label><label>Apellido materno<input name="apellido_materno" value="{{ old('apellido_materno') }}"></label><label>Teléfono<input name="telefono" maxlength="20" value="{{ old('telefono') }}"></label></div><button>Enviar solicitud</button></form></div>
@endif

@endsection
