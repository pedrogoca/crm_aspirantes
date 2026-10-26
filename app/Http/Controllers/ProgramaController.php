<?php
namespace App\Http\Controllers;
use App\Models\ProgramaAcademico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
class ProgramaController extends Controller {
    public function index(){return view('programas.index',['programas'=>ProgramaAcademico::orderBy('nombre')->get()]);}
    public function store(Request $r){abort_unless($r->user()->rol==='ADMIN',403);$d=$r->validate(['nombre'=>'required|string|max:150','modalidad'=>'required|in:ESCOLARIZADA,MIXTA,EN_LINEA']);ProgramaAcademico::create([...$d,'activo'=>true]);return back()->with('ok','Programa registrado.');}
}
