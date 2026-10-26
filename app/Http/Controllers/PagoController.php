<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,Pago};
use Illuminate\Http\Request;
class PagoController extends Controller {
    public function store(Request $r,Aspirante $aspirante){
        abort_unless($r->user()->esPersonal(),403);
        $d=$r->validate(['concepto'=>'required|string|max:150','monto'=>'required|numeric|min:0|max:99999999']);
        Pago::create([...$d,'id_aspirante'=>$aspirante->id_aspirante]);return back()->with('ok','Pago registrado como pendiente.');
    }
    public function update(Request $r,Pago $pago){
        abort_unless($r->user()->esPersonal(),403);
        $d=$r->validate(['estatus'=>'required|in:PENDIENTE,VALIDADO,RECHAZADO']);$pago->update($d);return back()->with('ok','Pago actualizado.');
    }
}
