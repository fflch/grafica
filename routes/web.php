<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\FileController;

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
Route::get('logout',[LoginController::class, 'logout'])->name('logout');

Route::resource('orcamentos', OrcamentoController::class);
Route::resource('files', FileController::class);
Route::resource('pedidos', PedidoController::class);

Route::post('pedidos/enviar_analise/{pedido}', [PedidoController::class,'enviar_analise']);
Route::post('pedidos/devolver/{pedido}', [PedidoController::class,'devolver']);
Route::post('pedidos/enviar_orcamento/{pedido}', [PedidoController::class,'enviar_orcamento']);
Route::post('pedidos/autorizacao/{pedido}', [PedidoController::class,'autorizacao']);
Route::post('pedidos/enviar_autorizacao/{pedido}/{autorizacao}', [PedidoController::class,'enviar_autorizacao']);
Route::post('pedidos/impressao/{pedido}', [PedidoController::class,'impressao']);
Route::post('pedidos/acabamento/{pedido}', [PedidoController::class,'acabamento']);
Route::post('pedidos/finalizar/{pedido}', [PedidoController::class,'finalizar']);
