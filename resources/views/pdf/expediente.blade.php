<!DOCTYPE html>
<html lang="es"><head><meta charset="utf-8"><title>Ficha de aspirante</title>
<style>
@page { margin: 32px 38px; }
body { font-family: DejaVu Sans, sans-serif; color:#1e293b; font-size:11px; }
h1 { font-size:19px; color:#1e3463; margin:0 0 5px; }
h2 { font-size:13px; margin:18px 0 7px; color:#1e3463; }
.meta { font-size:10px; color:#64748b; margin-bottom:18px; }
table { width:100%; border-collapse:collapse; table-layout:fixed; }
th,td { border:1px solid #dbe2ea; padding:7px; text-align:left; word-wrap:break-word; }
th { background:#eff4f9; }
.note { font-size:9px; color:#64748b; margin-top:19px; }
</style></head><body>
<h1>CRM de Aspirantes — Ficha de expediente</h1>
<div class="meta">Documento generado desde el sistema institucional. Folio: #{{ $a->id_aspirante }}</div>
<table>
<tr><th>Nombre</th><td>{{ trim($a->nombre.' '.$a->apellido_paterno.' '.($a->apellido_materno ?? '')) }}</td></tr>
<tr><th>Programa</th><td>{{ $a->programa?->nombre ?? 'Sin programa' }}</td></tr>
<tr><th>Estatus</th><td>{{ $a->estatus }}</td></tr>
<tr><th>Fecha de registro</th><td>{{ $a->fecha_registro }}</td></tr>
<tr><th>Teléfono</th><td>{{ $a->telefono ?: 'No registrado' }}</td></tr>
</table>
<h2>Documentos</h2>
<table><tr><th>Tipo</th><th>Estatus</th></tr>
@forelse($a->documentos as $d)
<tr><td>{{ $d->tipo_documento }}</td><td>{{ $d->estatus }}</td></tr>
@empty <tr><td colspan="2">Sin documentos</td></tr> @endforelse
</table>
<h2>Pagos registrados</h2>
<table><tr><th>Concepto</th><th>Monto (MXN)</th><th>Estatus</th></tr>
@forelse($a->pagos as $p)
<tr><td>{{ $p->concepto }}</td><td>${{ number_format((float)$p->monto,2) }}</td><td>{{ $p->estatus }}</td></tr>
@empty <tr><td colspan="3">Sin pagos</td></tr> @endforelse
</table>
<h2>Seguimiento</h2>
<table><tr><th>Fecha</th><th>Estatus</th><th>Observaciones</th></tr>
@forelse($a->seguimientos->sortByDesc('fecha') as $s)
<tr><td>{{ $s->fecha }}</td><td>{{ $s->estatus }}</td><td>{{ $s->observaciones ?: 'Sin observaciones' }}</td></tr>
@empty <tr><td colspan="3">Sin seguimientos</td></tr> @endforelse
</table>
<div class="note">Uso interno o del titular. El reporte refleja los registros disponibles al momento de la descarga.</div>
</body></html>
