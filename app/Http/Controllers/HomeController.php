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
            $query = Pedido::currentStatus("{$request->busca_status}")->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc'); 
        }
        else{
            $query = Pedido::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc'); 
        }
        if($request->busca_tipo != ''){
            $query->where('tipo','=', $request->busca_tipo);
        }
        
        $pedidos = $query->paginate(20);
        
        if ($pedidos->count() == null) {
            $request->session()->flash('alert-danger', 'Não há registros!');
        }
        return view('home')->with('pedidos',$pedidos);
    }
}
