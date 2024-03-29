<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Pedido;
use Carbon\Carbon;
use Uspdev\Replicado\Pessoa;

class PdfController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function gerarDocumentoContabilidade(Pedido $pedido, Request $request){
        $this->authorize('owner.pedido', $pedido);
        $observacao = $request->observacao;
        $pdf = PDF::loadView("pdfs.documento_contabilidade", compact(['pedido','observacao']));
        return $pdf->download("documento_contabilidade.pdf");
    }
}
