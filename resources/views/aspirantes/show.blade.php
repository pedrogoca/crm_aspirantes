
@extends('layouts.app')

@section('title','Expediente #'.$a->id_aspirante)

@section('content')
<div class="card"><h2>{{ $a->nombre }} {{ $a->apellido_paterno }} {{ $a->apellido_materno }}</h2><p><b>Programa:</b> {{ $a->programa->nombre }} | <b>Estatus:</b> {{ $a->estatus }} | <b>Teléfono:</b> {{ $a->telefono ?: 'Sin registrar' }}</p></div>

@if(auth()->user()->esPersonal())
<div class="card"><h2>Actualizar estatus de admisión</h2><form method="post" action="{{ route('aspirantes.update',$a) }}">
@csrf 
@method('PATCH')
<label>Nuevo estatus<select name="estatus">
@foreach(['REGISTRADO','EN_REVISION','ACEPTADO','RECHAZADO'] as $es)
<option value="{{ $es }}" @selected($es===$a->estatus)>{{ $es }}</option>
@endforeach
</select></label><label>Observaciones<textarea name="observaciones"></textarea></label><button>Actualizar</button></form></div>
@endif
<div class="card"><h2>Documentos del expediente</h2><table><thead><tr><th>Documento</th><th>Estado</th><th>Observaciones</th><th>Acciones</th></tr></thead><tbody>
@forelse($a->documentos as $d)
<tr><td>{{ $d->tipo_documento }}</td><td>{{ $d->estatus }}</td><td>{{ $d->observaciones }}</td><td><a href="{{ route('documentos.download',$d) }}">Descargar</a>
@if(auth()->user()->esPersonal())
<form method="post" action="{{ route('documentos.update',$d) }}" class="inline-form">
@csrf 
@method('PATCH')
<select name="estatus"><option>PENDIENTE</option><option>ACEPTADO</option><option>RECHAZADO</option></select><input name="observaciones" placeholder="Observación" maxlength="3000"><button>Revisar</button></form>
@endif
</td></tr>
@empty
<tr><td colspan="4">Sin documentos cargados.</td></tr>
@endforelse
</tbody></table><h3>Subir documento</h3><form method="post" enctype="multipart/form-data" action="{{ route('documentos.store',$a) }}">
@csrf
<div class="grid"><label>Tipo<input name="tipo_documento" required placeholder="Acta de nacimiento"></label><label>Archivo PDF/JPG/PNG (máximo 5 MB)<input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png" required></label></div><button>Subir</button></form></div>
<div class="card"><h2>Pagos</h2><table><thead><tr><th>Concepto</th><th>Monto</th><th>Estatus</th><th>Acciones</th></tr></thead><tbody>
@forelse($a->pagos as $p)
<tr><td>{{ $p->concepto }}</td><td>${{ number_format($p->monto,2) }}</td><td>{{ $p->estatus }}</td><td>
@if(auth()->user()->esPersonal())
<form method="post" action="{{ route('pagos.update',$p) }}" class="inline-form">
@csrf 
@method('PATCH')
<select name="estatus"><option>PENDIENTE</option><option>VALIDADO</option><option>RECHAZADO</option></select><button>Guardar</button></form>
@endif
</td></tr>
@empty
<tr><td colspan="4">Sin registros de pago.</td></tr>
@endforelse
</tbody></table>
@if(auth()->user()->esPersonal())
<h3>Registrar pago administrativo</h3><form action="{{ route('pagos.store',$a) }}" method="post">
@csrf
<div class="grid"><label>Concepto<input name="concepto" required></label><label>Monto<input type="number" name="monto" step="0.01" min="0" required></label></div><button>Guardar pago</button></form>
@endif
</div>
<div class="card"><h2>Historial de seguimiento</h2><table><thead><tr><th>Fecha</th><th>Responsable</th><th>Estatus</th><th>Observaciones</th></tr></thead><tbody>
@forelse($a->seguimientos->sortByDesc('fecha') as $s)
<tr><td>{{ $s->fecha }}</td><td>{{ $s->usuario->name }}</td><td>{{ $s->estatus }}</td><td>{{ $s->observaciones }}</td></tr>
@empty
<tr><td colspan="4">Sin movimientos registrados.</td></tr>
@endforelse
</tbody></table>
@if(auth()->user()->esPersonal())
<form method="post" action="{{ route('seguimiento.store',$a) }}">
@csrf
<label>Agregar observación<textarea name="observaciones" required></textarea></label><button>Registrar seguimiento</button></form>
@endif
</div>

@endsection
