<?php

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

Route::get('/', 'IndexController@index');


Route::get('/orcamento/create', 'OrcamentoController@create');
Route::post('/orcamento','OrcamentoController@store');



Route::get('/orcamento/consulta', 'OrcamentoController@consulta');
Route::get('/orcamento/criarCs', 'OrcamentoController@criarCs');
