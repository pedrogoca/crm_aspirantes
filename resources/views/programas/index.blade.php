
@extends('layouts.app')

@section('title','Programas académicos')

@section('content')

@if(auth()->user()->rol==='ADMIN')
<div class="card"><h2>Registrar programa</h2><form method="post" action="{{ route('programas.store') }}">
@csrf
<div class="grid"><label>Nombre<input name="nombre" required></label><label>Modalidad<select name="modalidad"><option>ESCOLARIZADA</option><option>MIXTA</option><option>EN_LINEA</option></select></label></div><button>Guardar</button></form></div>
@endif
<div class="card"><table><thead><tr><th>ID</th><th>Programa</th><th>Modalidad</th><th>Activo</th></tr></thead><tbody>
@forelse($programas as $p)
<tr><td>{{ $p->id_programa }}</td><td>{{ $p->nombre }}</td><td>{{ $p->modalidad }}</td><td>{{ $p->activo ? 'Sí':'No' }}</td></tr>
@empty
<tr><td colspan="4">No existen programas.</td></tr>
@endforelse
</tbody></table></div>
@endsection
