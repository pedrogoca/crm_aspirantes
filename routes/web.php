<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,DashboardController,ProgramaController,AspiranteController,DocumentoController,PagoController,SeguimientoController};
Route::middleware('guest')->group(function () {
    Route::get('/login',[AuthController::class,'loginForm'])->name('login');
    Route::post('/login',[AuthController::class,'login'])->name('login.store');
    Route::get('/registro',[AuthController::class,'registerForm'])->name('register');
    Route::post('/registro',[AuthController::class,'register'])->name('register.store');
});
Route::middleware('auth')->group(function () {
    Route::post('/salir',[AuthController::class,'logout'])->name('logout');
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/programas',[ProgramaController::class,'index'])->name('programas.index');
    Route::post('/programas',[ProgramaController::class,'store'])->name('programas.store');
    Route::get('/aspirantes',[AspiranteController::class,'index'])->name('aspirantes.index');
    Route::post('/aspirantes',[AspiranteController::class,'store'])->name('aspirantes.store');
    Route::get('/aspirantes/{aspirante}',[AspiranteController::class,'show'])->name('aspirantes.show');
    Route::patch('/aspirantes/{aspirante}',[AspiranteController::class,'update'])->name('aspirantes.update');
    Route::post('/aspirantes/{aspirante}/documentos',[DocumentoController::class,'store'])->name('documentos.store');
    Route::get('/documentos/{documento}/descargar',[DocumentoController::class,'download'])->name('documentos.download');
    Route::patch('/documentos/{documento}',[DocumentoController::class,'update'])->name('documentos.update');
    Route::post('/aspirantes/{aspirante}/pagos',[PagoController::class,'store'])->name('pagos.store');
    Route::patch('/pagos/{pago}',[PagoController::class,'update'])->name('pagos.update');
    Route::post('/aspirantes/{aspirante}/seguimiento',[SeguimientoController::class,'store'])->name('seguimiento.store');
});
