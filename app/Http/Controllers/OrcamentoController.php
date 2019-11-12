<?php

namespace App\Http\Controllers;

use App\Orcamento;
use Illuminate\Http\Request;

class OrcamentoController extends Controller
{

    /* Views */
    public function create()
    {
        return view('orcamento/create');
    }

    public function consulta()
    {
        return view('orcamento/consulta');
    }

    public function criarCs()
    {
        return 'criarCs';
    }


    /* Coletando os dados */

    public function store(Request $request)
    {
        /* Recebendo e salvando os itens no banco de dados */
        $orcamento = new Orcamento;
        $orcamento->titulo = $request->titulo;
        $orcamento->procedencia = $request->procedencia;
        $orcamento->area = $request->area;
        $orcamento->responsavel = $request->responsavel;
        $orcamento->tiragem = $request->tiragem;
        $orcamento->originais = $request->originais;
        $orcamento->formato = $request->formato;
        $orcamento->fonte = $request->fonte;
        $orcamento->observacao = $request->observacao;
        $orcamento->ano = $request->ano;
        $orcamento->cs = $request->cs;
        $orcamento->entrada = $request->entrada;

        $orcamento->save();
        return redirect('/');
    }



}
