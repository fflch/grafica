<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Orcamento;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use Storage;
use Carbon\Carbon;
use App\Models\File;
use App\Models\Chat;
use Uspdev\Replicado\Pessoa;
use App\Services\PedidoStepper;
use App\Jobs\AnaliseJob;
use App\Jobs\OrcamentoJob;
use App\Jobs\DevolucaoJob;
use App\Jobs\AutorizacaoJob;
use App\Jobs\AutorizadoJob;
use App\Jobs\EditoraJob;
use App\Jobs\GraficaJob;
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
        
        if($request->filtro_busca == 'numero_nome'){
            $query->where(function($query) use($request){
                $query->orWhere('users.name', 'LIKE', "%$request->busca%");
                $query->orWhere('users.codpes', '=', "$request->busca");
                $query->orWhere('pedidos.descricao', 'LIKE', "%$request->busca%");
            });
        }
        elseif($request->filtro_busca == 'data'){
            $data = Carbon::CreatefromFormat('d/m/Y', "$request->busca_data");
            $query->whereDate('pedidos.created_at','=', $data);
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
    public function enviarParaAnalise(Pedido $pedido, Request $request){
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
    public function enviarParaOrcamento(Pedido $pedido, Request $request){
        $this->authorize('servidor');
        if($request->button == 'orcamento'){
            $pedido->setStatus('Orçamento', $request->reason);
            $tipos_editora = ['Diagramação', 'Diagramação + Impressão', 'ISBN+DOI+Ficha Catalográfica'];
            if(in_array($pedido->tipo, $tipos_editora)){
                foreach(explode(',', trim(env('EDITORA'))) as $codpes){
                    if(Pessoa::emailusp($codpes)){  
                        OrcamentoJob::dispatch($pedido, $codpes);
                    }
                }
            }
            $tipos_grafica = ['Impressão', 'Diagramação + Impressão', 'Blocagem', 'Refile'];
            if(in_array($pedido->tipo, $tipos_grafica)){
                foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
                    if(Pessoa::emailusp($codpes)){
                        OrcamentoJob::dispatch($pedido, $codpes);
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

    //Função ativada após feitura do orçamento, em que a editora ou gráfica
    //envia o orçamento para o usuário e para o responsável do centro de despesa para que este autorize
    public function enviarOrcamentoParaAutorizacao(Pedido $pedido, Request $request){
        $this->authorize('servidor');
        if($request->percentual_sobre_insumos == 'on'){
            $pedido->percentual_sobre_insumos = 1;
            $pedido->update();
            $orcamento = new Orcamento;
            $orcamento->pedido_id = $pedido->id;
            $orcamento->procedencia = 'grafica';
            $orcamento->preco = 0.3 * $pedido->orcamentos()->where('procedencia','grafica')->get()->sum("preco");
            $orcamento->nome = "30% sobre os materiais utilizados";
            $orcamento->save();
        }
        else{
            $orcamento = $pedido->orcamentos()->where('nome','LIKE', '%sobre os materiais utilizados%')->delete();
        }
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
    public function enviarPedidoParaSetores(Pedido $pedido, Request $request){
        if($request->button == 'autorizado'){
            $request->validate([
                'termo_responsavel_centro_despesa' => 'required',
            ]);
        }
        $this->authorize('owner.pedido', $pedido);
        if($request->button == 'autorizado'){
            AutorizadoJob::dispatch($pedido);
            if($pedido->tipo == 'Diagramação' or $pedido->tipo == 'Diagramação + Impressão' or $pedido->tipo == 'ISBN+DOI+Ficha Catalográfica'){
                $pedido->setStatus('Editora', $request->reason);
                foreach(explode(',', trim(env('EDITORA'))) as $codpes){
                    if(Pessoa::emailusp($codpes)){
                        EditoraJob::dispatch($pedido, $codpes);
                    }
                }
            }
            else{
                $pedido->setStatus('Gráfica', $request->reason);
                foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
                    if(Pessoa::emailusp($codpes)){
                        GraficaJob::dispatch($pedido, $codpes);
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

    //Função que encaminha para a Gráfica assim que termina o trabalho da Editora
    public function enviarParaGrafica(Pedido $pedido, Request $request){
        $this->authorize('editora');
        $pedido->formato = $request->formato;
        $pedido->paginas_diagramadas = $request->paginas_diagramadas;
        $pedido->update();
        $pedido->setStatus('Gráfica', $request->reason);
        foreach(explode(',', trim(env('GRAFICA'))) as $codpes){
            if(Pessoa::emailusp($codpes)){
                GraficaJob::dispatch($pedido, $codpes);
            }
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    //Função que avisa o usuário da finalização do pedido
    public function finalizarPedido(Pedido $pedido, Request $request){
        $this->authorize('servidor');
        if($pedido->tipo == 'Diagramação + Impressão' or $pedido->tipo == 'Impressão' or $pedido->tipo == 'Blocagem' or $pedido->tipo == 'Refile'){
            $pedido->formato = $request->formato;
            $pedido->tiragem = $request->tiragem;
            $pedido->originais = $request->originais;
            $pedido->impressos = $request->impressos;
        }
        else{
            $pedido->formato = $request->formato;
            $pedido->paginas_diagramadas = $request->paginas_diagramadas;
        }
        $pedido->setStatus('Finalizado', $request->reason);
        $pedido->updated_at = date('Y-m-d H:i:s');
        $pedido->update();
        FinalizarJob::dispatch($pedido);
        return redirect("/pedidos/{$pedido->id}");
    }

    //Função para link de acesso temporário do arquivo do pedido
    public function acessoAutorizado(Request $request)
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

    public function voltarStatus(Pedido $pedido){
        $this->authorize('admin');
        for($i = 0; $i < 7; $i++){
            if($pedido->status == Pedido::status[$i]){ break; }
        }
        $pedido->setStatus(Pedido::status[$i-1]);
        $pedido->update();
        return redirect('/pedidos/'.$pedido->id);
    }    

}
