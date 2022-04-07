<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GeneralSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class,'home']);
Route::get('pedidos/visualizar_pedidos_a_autorizar', [HomeController::class,'visualizarPedidosAAutorizar']);

Route::post('pedidos/enviar_para_analise/{pedido}', [PedidoController::class,'enviarParaAnalise']);
Route::post('pedidos/enviar_para_orcamento/{pedido}', [PedidoController::class,'enviarParaOrcamento']);
Route::post('pedidos/enviar_para_autorizacao/{pedido}', [PedidoController::class,'enviarOrcamentoParaAutorizacao']);
Route::post('pedidos/enviar_pedido_para_setores/{pedido}', [PedidoController::class,'enviarPedidoParaSetores']);
Route::post('pedidos/enviar_para_grafica/{pedido}', [PedidoController::class,'enviarParaGrafica']);
Route::post('pedidos/finalizar_pedido/{pedido}', [PedidoController::class,'finalizarPedido']);
Route::post('pedidos/voltar_status/{pedido}', [PedidoController::class,'voltarStatus']);

Route::resource('orcamentos', OrcamentoController::class);
Route::resource('files', FileController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('chats', ChatController::class);

#settings
Route::get('/settings',[GeneralSettingsController::class, 'show']);
Route::post('/settings',[GeneralSettingsController::class, 'update']);

# Logs  
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:admins');

# Pdfs
Route::any('/pedidos/gerar_documento_contabilidade/{pedido}',[PdfController::class, 'gerarDocumentoContabilidade']);