<?php

namespace App\Http\Controllers;

use App\Models\Aspirante;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpedientePdfController extends Controller
{
    public function download(Request $request, Aspirante $aspirante): Response
    {
        $user = $request->user();
        abort_unless(
            $user->esPersonal() || (int) $aspirante->id_usuario === (int) $user->id,
            403
        );

        $aspirante->load(['programa', 'documentos', 'pagos', 'seguimientos.usuario']);
        $pdf = Pdf::loadView('pdf.expediente', ['a' => $aspirante])
            ->setPaper('a4', 'portrait');

        return $pdf->download('expediente-aspirante-' . $aspirante->id_aspirante . '.pdf');
    }
}
