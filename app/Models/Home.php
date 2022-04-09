<?php

namespace App\Models;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Pedido;

class Home
{
		public static function retornarPedidos(Request $request, $user_id){
				$query = Pedido::orderBy('created_at', 'desc');

				$request->validate([
					'busca_tipo' => ['nullable',Rule::in(Pedido::tipoPedidoOptions())],
					'busca_status' => ['nullable',Rule::in(Pedido::status)],
				]);

				$busca_tipo = $request->busca_tipo;
				$busca_status = $request->busca_status;

				$query->when($busca_tipo, function($query, $busca_tipo){
						$query->where('tipo', $busca_tipo);
				});

				$query->when($busca_status, function($query, $busca_status){
						$query->currentStatus("{$busca_status}");
				});

				if(auth()->user()->can('autorizador')){
						$query->currentStatus("Em Análise")
									->orWhere('user_id', $user_id);
				}

				if(auth()->user()->can('editora')){
						$query->currentStatus(["Orçamento","Editoração"])
									->whereIn('tipo',['Editoração', 'Editoração + Artes Gráficas'])
									->orWhere('user_id', $user_id);
				}

				if(auth()->user()->can('grafica')){
						$query->currentStatus(["Orçamento","Artes Gráficas"])
									->whereIn('tipo',['Artes Gráficas', 'Editoração + Artes Gráficas'])
									->orWhere('user_id', $user_id);
				}

				if(auth()->user()->can('logado')) $query->where('user_id', $user_id);

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

