<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,Documento};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DocumentoController extends Controller {
    private function permite(Request $r,Aspirante $a):void {abort_unless($r->user()->esPersonal()||$a->id_usuario===$r->user()->id,403);}
    public function store(Request $r,Aspirante $aspirante){
        $this->permite($r,$aspirante);
        $d=$r->validate(['tipo_documento'=>'required|string|max:100','archivo'=>'required|file|mimes:pdf,jpg,jpeg,png|max:5120']);
        $ruta=$r->file('archivo')->store('expedientes/'.$aspirante->id_aspirante,'local');
        Documento::create(['id_aspirante'=>$aspirante->id_aspirante,'tipo_documento'=>$d['tipo_documento'],'ruta_archivo'=>$ruta]);
        return back()->with('ok','Documento enviado.');
    }
    public function download(Request $r,Documento $documento){$this->permite($r,$documento->aspirante);abort_unless(Storage::disk('local')->exists($documento->ruta_archivo),404);return Storage::disk('local')->download($documento->ruta_archivo);}
    public function update(Request $r,Documento $documento){
        abort_unless($r->user()->esPersonal(),403);
        $d=$r->validate(['estatus'=>'required|in:PENDIENTE,ACEPTADO,RECHAZADO','observaciones'=>'nullable|string|max:3000']);
        $documento->update($d);return back()->with('ok','Documento revisado.');
    }
}
