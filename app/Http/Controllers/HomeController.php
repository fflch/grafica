<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Pedido;

class HomeController extends Controller
{
    public function home(Request $request){
        $this->authorize('logado');
        $query = Pedido::orderBy('created_at', 'desc');
        $request->validate([
            'busca_tipo' => ['nullable',Rule::in(Pedido::tipoPedidoOptions())],
            'busca_status' => ['nullable',Rule::in(Pedido::status)],
        ]);

        if($request->busca_status != ''){
            $query->currentStatus("{$request->busca_status}");
        }
        if($request->busca_tipo != ''){
            $query->where('tipo','=', $request->busca_tipo);
        }

        if(auth()->user()->can('autorizador')){
            $query->currentStatus("Em Análise");
            $query->orWhere('user_id', auth()->user()->id);
        }
        elseif(auth()->user()->can('editora')){
            $query->currentStatus(["Orçamento","Diagramação"])->whereIn('tipo',['Diagramação', 'Diagramação + Impressão']);
            $query->orWhere('user_id', auth()->user()->id);
        }
        elseif(auth()->user()->can('grafica')){
            $query->currentStatus(["Orçamento","Impressão"])->whereIn('tipo',['Impressão', 'Diagramação + Impressão']);
            $query->orWhere('user_id', auth()->user()->id);
        }
        else{
            $query->where('user_id', auth()->user()->id);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('home')->with('pedidos',$pedidos);
    }

    public function visualizarPedidosAAutorizar(Request $request){
        $this->authorize('logado');
        $query = Pedido::currentStatus("Autorização")->join('users', 'users.id', '=', 'pedidos.user_id')->where('responsavel_centro_despesa', auth()->user()->codpes)->orderBy('pedidos.created_at', 'desc')->select('pedidos.*'); 
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('pedidos.autorizacao_pedidos')->with('pedidos',$pedidos);
    }
}
