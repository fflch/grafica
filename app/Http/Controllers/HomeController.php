<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Pedido;

class HomeController extends Controller
{
    public function home(Request $request){
        $this->authorize('logado');
        $request->validate([
            'busca_tipo' => ['nullable',Rule::in(Pedido::tipoOptions())],
            'busca_status' => ['nullable',Rule::in(Pedido::status)],
        ]);
        if($request->busca_status != ''){
            $query = Pedido::currentStatus("{$request->busca_status}")->orderBy('created_at', 'desc'); 
        }
        else{
            $query = Pedido::orderBy('created_at', 'desc'); 
        }
        if(auth()->user()->can('autorizador')){
            $query->currentStatus("Em Análise");
        }
        elseif(auth()->user()->can('editora')){
            $query->currentStatus(["Orçamento","Editora"])->whereIn('tipo',['Diagramação', 'Diagramação + Impressão', 'ISBN+DOI+Ficha Catalográfica']);
        }
        elseif(auth()->user()->can('grafica')){
            $query->currentStatus(["Orçamento","Gráfica"])->whereIn('tipo',['Impressão', 'Diagramação + Impressão', 'Blocagem', 'Refile']);
        }
        
        $query->orWhere('user_id', auth()->user()->id);

        if($request->busca_tipo != ''){
            $query->where('tipo','=', $request->busca_tipo);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('home')->with('pedidos',$pedidos);
    }

    public function visualizarPedidosAAutorizar(Request $request){
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
        
        if ($pedidos->count() == null) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('pedidos.autorizacao_pedidos')->with('pedidos',$pedidos);
    }
}
