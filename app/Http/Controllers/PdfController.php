<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Pedido;
use Carbon\Carbon;
use Uspdev\Replicado\Pessoa;

class PdfController extends Controller
{
    //Bloco destinado aos documentos gerais
    public function documentoContabilidade(Pedido $pedido){
        $this->authorize('servidor');
        //$configs = Config::orderbyDesc('created_at')->first();
        $pdf = PDF::loadView("pdfs.documento_contabilidade", compact(['pedido']));
        return $pdf->download("documento_contabilidade.pdf");
    }
}
