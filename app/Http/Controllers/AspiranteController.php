<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,ProgramaAcademico,Seguimiento};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AspiranteController extends Controller {
    private function permite(Request $r,Aspirante $a): void {abort_unless($r->user()->esPersonal()||$a->id_usuario===$r->user()->id,403);}
    public function index(Request $r){
        $q=Aspirante::with('programa')->latest('fecha_registro');
        if(!$r->user()->esPersonal())$q->where('id_usuario',$r->user()->id);
        if($r->user()->esPersonal()&&$r->filled('buscar')){$buscar=$r->string('buscar')->toString();$q->where(function($x)use($buscar){$x->where('nombre','like',"%$buscar%")->orWhere('apellido_paterno','like',"%$buscar%");});}
        return view('aspirantes.index',['aspirantes'=>$q->paginate(15)->withQueryString()]);
    }
    public function store(Request $r){
        abort_if($r->user()->esPersonal(),403,'Registra un usuario aspirante para crear su solicitud.');
        abort_if(Aspirante::where('id_usuario',$r->user()->id)->exists(),422,'Ya existe una solicitud.');
        $d=$r->validate(['id_programa'=>'required|exists:programas_academicos,id_programa','nombre'=>'required|string|max:100','apellido_paterno'=>'required|string|max:100','apellido_materno'=>'nullable|string|max:100','telefono'=>'nullable|string|max:20']);
        abort_unless(ProgramaAcademico::whereKey($d['id_programa'])->where('activo',1)->exists(),422);
        $a=Aspirante::create([...$d,'id_usuario'=>$r->user()->id]);return redirect()->route('aspirantes.show',$a)->with('ok','Solicitud registrada.');
    }
    public function show(Request $r,Aspirante $aspirante){
        $this->permite($r,$aspirante);
        return view('aspirantes.show',['a'=>$aspirante->load(['programa','documentos','pagos','seguimientos.usuario'])]);
    }
    public function update(Request $r,Aspirante $aspirante){
        abort_unless($r->user()->esPersonal(),403);
        $d=$r->validate(['estatus'=>'required|in:REGISTRADO,EN_REVISION,ACEPTADO,RECHAZADO','observaciones'=>'nullable|string|max:3000']);
        DB::transaction(function()use($r,$aspirante,$d){$aspirante->update(['estatus'=>$d['estatus']]);Seguimiento::create(['id_aspirante'=>$aspirante->id_aspirante,'id_usuario'=>$r->user()->id,'estatus'=>$d['estatus'],'observaciones'=>$d['observaciones']??null]);});
        return back()->with('ok','Estatus actualizado y registrado en seguimiento.');
    }
}
