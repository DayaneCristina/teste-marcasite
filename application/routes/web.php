<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\PropostaController;
use App\Http\Controllers\ServicoController;

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

Route::get('/listar-parcelas/{id}', [ParcelaController::class, 'listar']);
Route::post('/criar-parcela',[ParcelaController::class, 'criar']);
Route::get('/criar-parcela/{id}', function(){
    return view ('criar-parcela');
});

Route::get('/', [PropostaController::class, 'listar']);
Route::get('/listar-propostas', [PropostaController::class, 'listar']);
Route::post('/listar-propostas', [PropostaController::class, 'listar']);
Route::post('/criar-proposta', [PropostaController::class, 'criar']);
Route::post('/atualizar-status', [PropostaController::class, 'atualizarStatus']);
Route::get('/criar-proposta', [PropostaController::class, 'viewCriar']);
Route::get('/criar-proposta/{id}', [PropostaController::class, 'viewEditar']);
Route::get('/deletar-proposta/{id}', [PropostaController::class, 'deletar']);

Route::get('/listar-servicos', [ServicoController::class, 'listar']);
Route::post('/criar-servico',[ServicoController::class, 'criar']);
Route::get('/criar-servico', function(){
    return view ('criar-servico');
});
Route::get('/criar-servico/{id}', [ServicoController::class, 'viewEditar']);

Route::get('/listar-empresas',[EmpresaController::class, 'listar']);
Route::post('/criar-empresa',[EmpresaController::class, 'criar']);
Route::get('/criar-empresa', function(){
    return view ('criar-empresa');
});
Route::get('/criar-empresa/{id}',[EmpresaController::class, 'viewEditar']);
Route::get('/pegar-responsavel/{cpf}',[EmpresaController::class, 'pegarResponsavel']);

Route::get('/listar-usuarios',[UserController::class, 'listar']);
Route::post('/criar-usuario', [UserController::class, 'criar']);
Route::get('/criar-usuario', function(){
    return view ('criar-usuario');
});
Route::get('/criar-usuario/{id}',[UserController::class, 'viewEditar']);

Route::get('/exportar-propostas', [PropostaController::class, 'exportarPropostas']);