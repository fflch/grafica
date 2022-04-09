<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Pedido;
use App\Models\Home;
use Auth;

class HomeController extends Controller
{
    public function home(Request $request){
				if (Auth::guest()) return view('index');

				$pedidos = Home::retornarPedidos($request, auth()->user()->id);
						
				if (!($pedidos->count())) {
						$request->session()->flash('alert-danger', 'Não há registros!');
				}

        return view('index')->with('pedidos',$pedidos);
    }

    public function visualizarPedidosAAutorizar(Request $request){
				$this->authorize('logado');

				$pedidos = Home::retornarPedidosAutorizar(auth()->user()->codpes);
			
				if (!($pedidos->count())) {
						$request->session()->flash('alert-danger', 'Não há registros!');
				}

        return view('pedidos.autorizacao_pedidos')->with('pedidos',$pedidos);
    }
}
