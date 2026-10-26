<?php
namespace App\Http\Controllers;
use App\Models\{Aspirante,Documento,Pago,ProgramaAcademico};
class DashboardController extends Controller {
    public function index(){
        $u=auth()->user();
        if(!$u->esPersonal())return view('dashboard',['personal'=>false,'aspirante'=>$u->aspirante,'programas'=>ProgramaAcademico::where('activo',1)->orderBy('nombre')->get()]);
        return view('dashboard',['personal'=>true,'indicadores'=>['Aspirantes'=>Aspirante::count(),'En revisión'=>Aspirante::where('estatus','EN_REVISION')->count(),'Documentos pendientes'=>Documento::where('estatus','PENDIENTE')->count(),'Pagos pendientes'=>Pago::where('estatus','PENDIENTE')->count()]]);
    }
}
