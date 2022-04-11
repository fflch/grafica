<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Pedido;

class Home
{

   public static function retornarPedidos(Request $request, $user_id){

       $request->validate([
           'busca_tipo' => ['nullable',Rule::in(Pedido::tipoPedidoOptions())],
           'busca_status' => ['nullable',Rule::in(Pedido::status)],
       ]);

       $query = Pedido::orderBy('created_at', 'desc');

       $query->when($request->busca_tipo, function($query) use ($request){
           $query->where('tipo', $request->busca_tipo);
       });

       $query->when($request->busca_status, function($query) use ($request){
           $query->currentStatus("{$request->busca_status}");
       });

       $query->when(auth()->user()->can('autorizador'), function($query) use ($user_id){
           $query->currentStatus("Em Análise")
                 ->orWhere('user_id', $user_id);
       });

       $query->when(auth()->user()->can('editora'), function($query) use ($user_id){
           $query->currentStatus(["Orçamento","Editoração"])
                 ->whereIn('tipo',['Editoração', 'Editoração + Artes Gráficas'])
                 ->orWhere('user_id', $user_id);
       });

       $query->when(auth()->user()->can('grafica'), function($query) use ($user_id){
           $query->currentStatus(["Orçamento","Artes Gráficas"])
                 ->whereIn('tipo',['Artes Gráficas', 'Editoração + Artes Gráficas'])
                 ->orWhere('user_id', $user_id);

       });

       $query->when(auth()->user()->can('logado'), function($query) use ($user_id){
           $query->where('user_id', $user_id);
       });

       return $query->paginate(20);
   }

   public static function retornarPedidosAutorizar($codpes){
       return Pedido::currentStatus("Autorização")
                    ->join('users', 'users.id', '=', 'pedidos.user_id')
                    ->where('responsavel_centro_despesa', $codpes)
                    ->orderBy('pedidos.created_at', 'desc')
                    ->select('pedidos.*')
                    ->paginate(20);
   }

}

