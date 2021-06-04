<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use Storage;
use App\Services\PedidoStepper;

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
        $stepper->setCurrentStepName($pedido->status);

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
        return redirect("/pedidos/{$pedido->id}");
    }

    public function enviarOrcamento(Pedido $pedido, Request $request){
        if($request->button == 'orcamento'){
            $pedido->setStatus('Orçamento', $request->reason);
        }
        else{
            $pedido->setStatus('Em Elaboração', $request->reason);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function autorizacao(Pedido $pedido, Request $request){
        $pedido->setStatus('Autorização', $request->reason);
        return redirect("/pedidos/{$pedido->id}");
    }

    public function enviarAutorizacao(Pedido $pedido, Request $request){
        if($request->button == 'autorizado'){
            if($pedido->tipo == 'Diagramação' or $pedido->tipo == 'Diagramação + Impressão'){
                $pedido->setStatus('Diagramação', $request->reason);
            }
            else{
                $pedido->setStatus('Impressão', $request->reason);
            }
        }
        else{
            $pedido->setStatus('Em Elaboração', $request->reason);
        }
        return redirect("/pedidos/{$pedido->id}");
    }

    public function impressao(Pedido $pedido, Request $request){
        $pedido->setStatus('Impressão', $request->reason);
        return redirect("/pedidos/{$pedido->id}");
    }

    public function acabamento(Pedido $pedido, Request $request){
        $pedido->setStatus('Acabamento', $request->reason);
        return redirect("/pedidos/{$pedido->id}");
    }

    public function finalizar(Pedido $pedido, Request $request){
        $pedido->setStatus('Finalizado', $request->reason);
        return redirect("/pedidos/{$pedido->id}");
    }

}
