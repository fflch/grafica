<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\GeneralSettings;
use App\Http\Requests\GeneralSettingsRequest;

class GeneralSettingsController extends Controller
{
    public function show(GeneralSettings $settings){
        $this->authorize('admin');
        return view('settings.show', [
            'em_analise' => $settings->em_analise,
            'orcamento' => $settings->orcamento,
            'autorizacao' => $settings->autorizacao,
            'autorizado' => $settings->autorizado,
            'diagramacao' => $settings->diagramacao,
            'impressao' => $settings->impressao,
            'finalizado' => $settings->finalizado,
            'devolucao' => $settings->devolucao,
        ]);
    }

    public function update(GeneralSettingsRequest $request, GeneralSettings $settings){
        $this->authorize('admin');
        $settings->em_analise = $request->input('em_analise');
        $settings->orcamento = $request->input('orcamento');
        $settings->autorizacao = $request->input('autorizacao');
        $settings->autorizado = $request->input('autorizado');
        $settings->diagramacao = $request->input('diagramacao');
        $settings->impressao = $request->input('impressao');
        $settings->finalizado = $request->input('finalizado');
        $settings->devolucao = $request->input('devolucao');
        
        $settings->save();
        
        return redirect()->back();
    }
}
