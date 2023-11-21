<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\RemoverController;
use App\Http\Controllers\ListarController;
use App\Http\Controllers\EditarController;

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('index');
});*/
Route::get('/', [LoginController::class, 'login'])->name('login');

Route::get('/cadastrar', [CadastroController::class, 'create']);
Route::post('/cadastrar2', [CadastroController::class, 'user']);
Route::post('/cadastrar3', [CadastroController::class, 'farmaciaFinal']);
Route::post('/storeCliente', [CadastroController::class, 'store']);
Route::post('/storeFarmacia', [CadastroController::class, 'storeFarmacia']);


Route::post('/home', [LoginController::class, 'entrar']);
Route::get('/home', [LoginController::class, 'pos_cad'])->name('home');

Route::middleware('auth')->group(function(){


    Route::get('/registrarProdutos', [RegistrarController::class, 'reg_prod'])->name('registrarProdutos');
    Route::post('/registrarProdutos', [RegistrarController::class, 'store_prod'])->name('salvarProdutos')->middleware('can:administrador');
    Route::get('/registrarMarcas', [RegistrarController::class, 'reg_marcas'])->name('registrarMarcas')->middleware('can:administrador');
    Route::post('/registrarMarcas', [RegistrarController::class, 'store_marcas'])->name('salvarMarcas')->middleware('can:administrador');
    Route::get('/registrarCategorias', [RegistrarController::class, 'reg_categorias'])->name('registrarCategorias')->middleware('can:administrador');
    Route::post('/registrarCategorias', [RegistrarController::class, 'store_categorias'])->name('salvarCategorias')->middleware('can:administrador');
    Route::get('/registrarAdministradores', [RegistrarController::class, 'reg_administradores'])->name('registrarAdministradores')->middleware('can:administrador');
    Route::post('/registrarAdministradores/{id}', [RegistrarController::class, 'store_administradores'])->name('salvarAdministradores')->middleware('can:administrador');
    Route::post('/removerAdministradores/{id}', [RemoverController::class, 'destroy_administradores'])->name('removerAdministrador')->middleware('can:administrador');
    Route::post('/registrarEstoque/{id}', [RegistrarController::class, 'reg_estoque'])->name('registrarEstoque')->middleware('can:administrador');
    Route::post('/salvarEstoque/{id}', [RegistrarController::class, 'store_estoque'])->name('salvarEstoque')->middleware('can:administrador');
    Route::post('/registrarCompra', [RegistrarController::class, 'reg_compra'])->name('registrarCompra');

    Route::get('/listarProdutos', [ListarController::class, 'list_prod'])->name('listarProdutos')->middleware('can:administrador');
    Route::get('/listarMarcas', [ListarController::class, 'list_marcas'])->name('listarMarcas')->middleware('can:administrador');
    Route::get('/listarCategorias', [ListarController::class, 'list_categorias'])->name('listarCategorias')->middleware('can:administrador');
    Route::get('/listarVendas', [ListarController::class, 'list_vendas'])->name('listarVendas')->middleware('can:administrador');
    Route::get('/listarEstoque/{id}', [ListarController::class, 'list_estoque'])->name('listarEstoque')->middleware('can:administrador');

    Route::get('/pedidos', [ListarController::class, 'list_pedidos'])->name('listarPedidos');
    Route::get('/formaPagamento', [ListarController::class, 'list_pagamento'])->name('formaPagamento');
    Route::any('/filtrarPedidos', [ListarController::class, 'list_filt_pedidos'])->name('filtrarPedidos');

    Route::post('/editarProduto/{id}', [EditarController::class, 'edit_prod'])->name('editarProduto')->middleware('can:administrador');
    Route::post('/editarMarca/{id}', [EditarController::class, 'edit_marca'])->name('editarMarca')->middleware('can:administrador');
    Route::post('/editarCategoria/{id}', [EditarController::class, 'edit_categoria'])->name('editarCategoria')->middleware('can:administrador');
    Route::get('/editarEstoque/{id}', [EditarController::class, 'edit_estoque'])->name('editarEstoque')->middleware('can:administrador');
    Route::get('/editarVenda/{id}', [EditarController::class, 'edit_venda'])->name('editarVenda')->middleware('can:administrador');
    Route::post('/storeEditProduto/{id}', [EditarController::class, 'store_prod'])->name('salvarEditProduto')->middleware('can:administrador');
    Route::post('/storeEditMarca/{id}', [EditarController::class, 'store_marca'])->name('salvarEditMarca')->middleware('can:administrador');
    Route::post('/storeEditCategoria/{id}', [EditarController::class, 'store_categoria'])->name('salvarEditCategoria')->middleware('can:administrador');
    Route::post('/storeEditEstoque/{id}', [EditarController::class, 'store_estoque'])->name('salvarEditEstoque')->middleware('can:administrador');
    Route::post('/storeEditVenda/{id}', [EditarController::class, 'store_venda'])->name('salvarEditVenda')->middleware('can:administrador');
    Route::POST('/storePerfil/{id}', [EditarController::class, 'store_perfil'])->name('salvarPerfil');
    Route::POST('/storeEndereco/{id}', [EditarController::class, 'store_endereco'])->name('salvarEndereco');
    Route::POST('/storeSenha', [EditarController::class, 'store_senha'])->name('salvarSenha');
    Route::get('/confirmarEndereco', [EditarController::class, 'confirmar_endereco'])->name('confirmarEndereco');
    Route::get('/perfil', [EditarController::class, 'edit_perfil'])->name('editarPerfil');
    Route::get('/endereco', [EditarController::class, 'edit_endereco'])->name('editarEndereco');
    Route::get('/senha', [EditarController::class, 'edit_senha'])->name('editarSenha');

    Route::post('/removerProduto/{id}', [EditarController::class, 'delete_prod'])->name('removerProduto')->middleware('can:administrador');
    Route::post('/removerEstoque/{id}', [EditarController::class, 'delete_estoque'])->name('removerEstoque')->middleware('can:administrador');
    Route::post('/removerMarca/{id}', [EditarController::class, 'delete_marca'])->name('removerMarca')->middleware('can:administrador');
    Route::post('/removerCategoria/{id}', [EditarController::class, 'delete_categoria'])->name('removerCategoria')->middleware('can:administrador');

});


Route::get('/carrinho', [ListarController::class, 'list_carrinho'])->name('listarCarrinho');
Route::get('/detalheProduto/{id}', [ListarController::class, 'detalhe_prod'])->name('detalheProduto');








Route::post('/teste', [LoginController::class, 'autenticacao']);
Route::get('/sair', function(){
    session()->flush();
    Auth::logout();
    return redirect('/');
});




