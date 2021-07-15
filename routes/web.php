<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginAdminController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ChatController;
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

Route::get('/', function () {
    return view('index');
});
Route::get('login',[LoginController::class, 'redirectToProvider'])->name('login');
Route::get('callback', [LoginController::class, 'handleProviderCallback']);
Route::post('logout',[LoginController::class, 'logout'])->name('logout');

Route::get('pedidos/meus_pedidos', [PedidoController::class,'meusPedidos']);
Route::get('pedidos/autorizacao_pedidos', [PedidoController::class,'autorizacaoPedidos']);
Route::post('pedidos/enviar_analise/{pedido}', [PedidoController::class,'enviarAnalise']);
Route::post('pedidos/enviar_orcamento/{pedido}', [PedidoController::class,'enviarOrcamento']);
Route::post('pedidos/autorizacao/{pedido}', [PedidoController::class,'autorizacao']);
Route::post('pedidos/enviar_autorizacao/{pedido}', [PedidoController::class,'enviarAutorizacao']);
Route::post('pedidos/impressao/{pedido}', [PedidoController::class,'impressao']);
Route::post('pedidos/finalizar/{pedido}', [PedidoController::class,'finalizar']);

Route::get('info', [PedidoController::class, 'info'])->name('pedidos.info');

Route::resource('orcamentos', OrcamentoController::class);
Route::resource('files', FileController::class);
Route::resource('pedidos', PedidoController::class);
Route::resource('chats', ChatController::class);

Route::get('/login_admin',[LoginAdminController::class, 'show']);
Route::post('/login_admin',[LoginAdminController::class, 'login']);

#settings
Route::get('/settings',[GeneralSettingsController::class, 'show']);
Route::post('/settings',[GeneralSettingsController::class, 'update']);

Route::get('acesso/autorizado', [PedidoController::class,'acesso_autorizado'])->name('acesso_autorizado');

# Logs  
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('can:admin');
