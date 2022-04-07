<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Pedido;
use Auth;

class HomeController extends Controller
{
    public function home(Request $request){
        if (Auth::guest()) return view('index');

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
            $query->currentStatus(["Orçamento","Editoração"])->whereIn('tipo',['Editoração', 'Editoração + Artes Gráficas']);
            $query->orWhere('user_id', auth()->user()->id);
        }
        elseif(auth()->user()->can('grafica')){
            $query->currentStatus(["Orçamento","Artes Gráficas"])->whereIn('tipo',['Artes Gráficas', 'Editoração + Artes Gráficas']);
            $query->orWhere('user_id', auth()->user()->id);
        }
        else{
            $query->where('user_id', auth()->user()->id);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('index')->with('pedidos',$pedidos);
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
