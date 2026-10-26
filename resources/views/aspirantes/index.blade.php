
@extends('layouts.app')

@section('title','Aspirantes')

@section('content')

@if(auth()->user()->esPersonal())
<form method="get" class="search"><input name="buscar" value="{{ request('buscar') }}" placeholder="Nombre o apellido"><button>Buscar</button></form>
@endif
<div class="card"><table><thead><tr><th>ID</th><th>Aspirante</th><th>Programa</th><th>Estatus</th><th>Fecha</th><th></th></tr></thead><tbody>
@forelse($aspirantes as $a)
<tr><td>{{ $a->id_aspirante }}</td><td>{{ $a->nombre }} {{ $a->apellido_paterno }}</td><td>{{ $a->programa->nombre }}</td><td><span class="tag">{{ $a->estatus }}</span></td><td>{{ $a->fecha_registro }}</td><td><a href="{{ route('aspirantes.show',$a) }}">Ver</a></td></tr>
@empty
<tr><td colspan="6">No hay solicitudes.</td></tr>
@endforelse
</tbody></table><p>{{ $aspirantes->links() }}</p></div>
@endsection
