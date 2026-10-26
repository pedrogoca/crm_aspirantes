<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,Seguimiento};
use Illuminate\Http\Request;
class SeguimientoController extends Controller {
    public function store(Request $r,Aspirante $aspirante){
        abort_unless($r->user()->esPersonal(),403);
        $d=$r->validate(['observaciones'=>'required|string|max:3000']);
        Seguimiento::create(['id_aspirante'=>$aspirante->id_aspirante,'id_usuario'=>$r->user()->id,'estatus'=>$aspirante->estatus,'observaciones'=>$d['observaciones']]);
        return back()->with('ok','Observación registrada.');
    }
}
