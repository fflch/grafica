<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use Storage;
use App\Models\File;
use App\Models\Chat;
use Uspdev\Replicado\Pessoa;
use App\Services\PedidoStepper;
use App\Jobs\AnaliseJob;
use App\Jobs\OrcamentoJob;
use App\Jobs\DevolucaoJob;
use App\Jobs\AutorizacaoJob;
use App\Jobs\AutorizadoJob;
use App\Jobs\DiagramacaoJob;
use App\Jobs\ImpressaoJob;
use App\Jobs\FinalizarJob;
use Illuminate\Validation\Rule;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('servidor');
        $request->validate([
            'busca_data' => 'required_if:filtro_busca,data|dateformat:d/m/Y|nullable',
            'busca_tipo' => ['nullable',Rule::in(Pedido::tipoOptions())],
            'busca_status' => ['nullable',Rule::in(Pedido::status)],
        ]);

        if($request->busca_status != ''){
            $query = Pedido::currentStatus("{$request->busca_status}")->join('users', 'users.id', '=', 'pedidos.user_id')->orderBy('pedidos.created_at', 'desc')->select('pedidos.*'); 
        }
        else{
            $query = Pedido::join('users', 'users.id', '=', 'pedidos.user_id')->orderBy('pedidos.created_at', 'desc')->select('pedidos.*'); 
        }
        
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

    public function meusPedidos(Request $request){
        $this->authorize('logado');
        $request->validate([
            'busca_tipo' => ['nullable',Rule::in(Pedido::tipoOptions())],
            'busca_status' => ['nullable',Rule::in(Pedido::status)],
        ]);

        if($request->busca_status != ''){
            $query = Pedido::currentStatus("{$request->busca_status}")->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc'); 
        }
        else{
            $query = Pedido::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc'); 
        }
        if($request->busca_tipo != ''){
            $query->where('tipo','=', $request->busca_tipo);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null and $request->busca != '') {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('pedidos.meus_pedidos')->with('pedidos',$pedidos);
    }

    public function autorizacaoPedidos(Request $request){
        $this->authorize('logado');
        $request->validate([
            'busca_tipo' => ['nullable',Rule::in(Pedido::tipoOptions())],
            'busca' => 'nullable',
            'busca_status' => ['nullable',Rule::in(Pedido::status)],
        ]);

        if($request->busca_status != ''){
            $query = Pedido::currentStatus("{$request->busca_status}")->join('users', 'users.id', '=', 'pedidos.user_id')->where('responsavel_centro_despesa', auth()->user()->codpes)->orderBy('pedidos.created_at', 'desc')->select('pedidos.*'); 
        }
        else{
            $query = Pedido::currentStatus("Autorização")->join('users', 'users.id', '=', 'pedidos.user_id')->where('responsavel_centro_despesa', auth()->user()->codpes)->orderBy('pedidos.created_at', 'desc')->select('pedidos.*'); 
        }
        
        if($request->busca != ''){
            $query->where(function($query) use($request){
                $query->orWhere('users.name', 'LIKE', "%$request->busca%");
                $query->orWhere('users.codpes', '=', "$request->busca");
                $query->orWhere('pedidos.descricao', 'LIKE', "%$request->busca%");
            });
        }
        if($request->busca_tipo != ''){
            $query->where('tipo','=', $request->busca_tipo);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null and $request->busca != '') {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('pedidos.autorizacao_pedidos')->with('pedidos',$pedidos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('logado');
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
        $this->authorize('logado');
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
        $this->authorize('owner.pedido',$pedido);
        $stepper->setCurrentStepName($pedido->latestStatus());
        $chats = Chat::where('pedido_id', $pedido->id)->orderBy('created_at','asc')->get();
        return view('pedidos.show', [
            'pedido' => $pedido,
            'stepper' => $stepper->render(),
            'chats' => $chats,
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
        $this->authorize('owner.pedido',$pedido);
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
        $this->authorize('owner.pedido',$pedido);
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
        $this->authorize('owner.pedido',$pedido);
        if($pedido->status == 'Em Elaboração'){
            $pedido->orcamentos()->delete();
            $files = $pedido->files;
            foreach($files as $file){
                Storage::delete($file->path);
            }
            $pedido->files()->delete();
            $pedido->delete();
            return redirect('/pedidos');
        }
    }

    //Funções de Status

    //Função que envia pedido para liberação do grupo AUTORIZADOR
    public function enviarAnalise(Pedido $pedido, Request $request){
        $this->authorize('owner.pedido', $pedido);
        $pedido->setStatus('Em Análise', $request->reason);
        foreach(explode(',', trim(env('AUTORIZADOR'))) as $codpes){
            if(Pessoa::emailusp($codpes)){
                AnaliseJob::dispatch($pedido, $codpes);
            }
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    //Função que envia pedido, caso liberado, para o grupo EDITORA e GRÁFICA
    //para que façam o orçamento do pedido
    //caso rejeitado, status volta para 'Em Elaboração' e é devolvido para o usuário
    public function enviarOrcamento(Pedido $pedido, Request $request){
        $this->authorize('servidor');
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

    //Função ativada após feitura do orçamento, em que a editora ou gráfica
    //envia o orçamento para o usuário e para o responsável do centro de despesa para que este autorize
    public function autorizacao(Pedido $pedido, Request $request){
        $this->authorize('servidor');
        $pedido->setStatus('Autorização', $request->reason);
        if(Pessoa::emailusp($pedido->responsavel_centro_despesa)){
            AutorizacaoJob::dispatch($pedido, $pedido->responsavel_centro_despesa);
        }
        if(Pessoa::emailusp($pedido->user->codpes)){
            AutorizacaoJob::dispatch($pedido, $pedido->user->codpes);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    //Função que trabalha com o resultado da autorização do Centro de Despesa e encaminha
    //para os próximos passos do sistema (indo para a Editora ou para a Gráfica)
    //também pode ocorrer do Centro de Despesa não liberar, então retorna para status 'Em Elaboração'
    public function enviarAutorizacao(Pedido $pedido, Request $request){
        $request->validate([
            'termo_responsavel_centro_despesa' => 'required',
        ]);
        $this->authorize('owner.pedido', $pedido);
        if($request->button == 'autorizado'){
            AutorizadoJob::dispatch($pedido);
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
            if($request->termo_responsavel_centro_despesa == 'on'){
                $pedido->termo_responsavel_centro_despesa = 1;
                $pedido->update();
            }
        }
        else{
            $pedido->setStatus('Em Elaboração', $request->reason);
            DevolucaoJob::dispatch($pedido);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    //Função que encaminha para a Gráfica assim que termina o status de Diagramação
    public function impressao(Pedido $pedido, Request $request){
        $this->authorize('editora');
        $pedido->setStatus('Impressão', $request->reason);
        foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
            if(Pessoa::emailusp($codpes)){
                ImpressaoJob::dispatch($pedido, $codpes);
            }
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    //Função que avisa o usuário da finalização do pedido
    public function finalizar(Pedido $pedido, Request $request){
        $this->authorize('servidor');
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

    //Função para link de acesso temporário do arquivo do pedido
    public function acesso_autorizado(Request $request)
    {
        if ($request->hasValidSignature()) {
            $file = File::find($request->file_id);
            return Storage::download($file->path, $file->original_name);
        } else {
            $request->session()->flash('alert-danger',
                "URL expirada!");
            return redirect('/');
        }
    }    

}
