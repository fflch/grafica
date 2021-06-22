<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use Storage;
use Uspdev\Replicado\Pessoa;
use App\Services\PedidoStepper;
use App\Jobs\AnaliseJob;
use App\Jobs\OrcamentoJob;
use App\Jobs\DevolucaoJob;
use App\Jobs\AutorizacaoJob;
use App\Jobs\DiagramacaoJob;
use App\Jobs\ImpressaoJob;
use App\Jobs\AcabamentoJob;
use App\Jobs\FinalizarJob;

class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'busca_data' => 'required_if:filtro_busca,data|dateformat:d/m/Y|nullable',
        ]);
        
        $query = Pedido::join('users', 'users.id', '=', 'pedidos.user_id')->orderBy('pedidos.created_at', 'desc')->select('pedidos.*'); 
        if($request->busca != ''){
            $query->where(function($query) use($request){
                $query->orWhere('users.name', 'LIKE', "%$request->busca%");
                $query->orWhere('users.codpes', '=', "$request->busca");
                $query->orWhere('pedidos.descricao', 'LIKE', "%$request->busca%");
            });
        }
        elseif($request->filtro_busca == 'data'){
            $data = Carbon::CreatefromFormat('d/m/Y', "$request->busca_data");
            $query->whereDate('data_da_defesa','=', $data);
        }
        if($request->busca_tipo != ''){
            $query->where('tipo','=', $request->busca_tipo);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null and $request->busca != '') {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('pedidos.index')->with('pedidos',$pedidos);
    }

    public function meusPedidos(){
        $pedidos = Pedido::where('user_id', auth()->user()->id)->paginate(20);
        return view('pedidos.meus_pedidos')->with('pedidos',$pedidos);
    }

    public function autorizacaoPedidos(){
        $pedidos = Pedido::where('responsavel_centro_despesa', auth()->user()->codpes)->paginate(20);
        return view('pedidos.autorizacao_pedidos')->with('pedidos',$pedidos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pedido = new Pedido;
        return view('pedidos.create')->with('pedido', $pedido);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PedidoRequest $request)
    {
        $validated = $request->validated();
        $pedido = Pedido::create($validated);
        $pedido->setStatus('Em Elaboração');
        //Salva o orientador na banca
        return redirect("/pedidos/$pedido->id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido, PedidoStepper $stepper)
    {
        $stepper->setCurrentStepName($pedido->latestStatus());

        return view('pedidos.show', [
            'pedido' => $pedido,
            'stepper' => $stepper->render(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function edit(Pedido $pedido)
    {
        return view('pedidos.edit')->with('pedido', $pedido);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function update(PedidoRequest $request, Pedido $pedido)
    {
        $validated = $request->validated();
        $pedido->update($validated);
        return redirect("/pedidos/$pedido->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->orcamentos()->delete();
        $files = $pedido->files;
        foreach($files as $file){
            Storage::delete($file->path);
        }
        $pedido->files()->delete();
        $pedido->delete();
        return redirect('/pedidos');
    }

    //Funções de Status
    public function enviarAnalise(Pedido $pedido, Request $request){
        $pedido->setStatus('Em Análise', $request->reason);
        foreach(explode(',', trim(env('AUTORIZADOR'))) as $codpes){
            if(Pessoa::emailusp($codpes)){
                AnaliseJob::dispatch($pedido, $codpes);
            }
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function enviarOrcamento(Pedido $pedido, Request $request){
        if($request->button == 'orcamento'){
            $pedido->setStatus('Orçamento', $request->reason);
            foreach(explode(',', trim(env('EDITORA'))) as $codpes){
                if(Pessoa::emailusp($codpes)){  
                    OrcamentoJob::dispatch($pedido, $codpes);
                }
            }
            foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
                if(Pessoa::emailusp($codpes)){
                    OrcamentoJob::dispatch($pedido, $codpes);
                }
            }
        }
        else{
            $pedido->setStatus('Em Elaboração', $request->reason);
            DevolucaoJob::dispatch($pedido);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function autorizacao(Pedido $pedido, Request $request){
        $pedido->setStatus('Autorização', $request->reason);
        if(Pessoa::emailusp($pedido->responsavel_centro_despesa)){
            AutorizacaoJob::dispatch($pedido);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function enviarAutorizacao(Pedido $pedido, Request $request){
        if($request->button == 'autorizado'){
            if($pedido->tipo == 'Diagramação' or $pedido->tipo == 'Diagramação + Impressão'){
                $pedido->setStatus('Diagramação', $request->reason);
                foreach(explode(',', trim(env('EDITORA'))) as $codpes){
                    if(Pessoa::emailusp($codpes)){
                        DiagramacaoJob::dispatch($pedido, $codpes);
                    }
                }
            }
            else{
                $pedido->setStatus('Impressão', $request->reason);
                foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
                    if(Pessoa::emailusp($codpes)){
                        ImpressaoJob::dispatch($pedido, $codpes);
                    }
                }
            }
        }
        else{
            $pedido->setStatus('Em Elaboração', $request->reason);
            DevolucaoJob::dispatch($pedido);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function impressao(Pedido $pedido, Request $request){
        $pedido->setStatus('Impressão', $request->reason);
        foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
            if(Pessoa::emailusp($codpes)){
                ImpressaoJob::dispatch($pedido, $codpes);
            }
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function acabamento(Pedido $pedido, Request $request){
        $pedido->setStatus('Acabamento', $request->reason);
        AcabamentoJob::dispatch($pedido);
        return redirect("/pedidos/{$pedido->id}");
    }

    public function finalizar(Pedido $pedido, Request $request){
        $pedido->setStatus('Finalizado', $request->reason);
        FinalizarJob::dispatch($pedido);
        return redirect("/pedidos/{$pedido->id}");
    }

    /* Api para entregar dados do(a) aluno(a) no blade */
    public function info(Request $request)
    {
        if(empty($request->codpes)){
            return response('Pessoa não encontrada');
        }

        if(!is_int((int)$request->codpes)){
            return response('Pessoa não encontrada');
        }

        if(strlen($request->codpes) < 6){
            return response('Pessoa não encontrada');
        }

        $info = Pessoa::nomeCompleto($request->codpes);
        if($info) {
            return response($info);
        } else {
            return response('Pessoa não encontrada');
        } 
    }

}
