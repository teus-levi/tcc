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
Route::get('/', [LoginController::class, 'login']);

Route::get('/cadastrar', [CadastroController::class, 'create']);
Route::post('/cadastrar2', [CadastroController::class, 'user']);
Route::post('/cadastrar3', [CadastroController::class, 'farmaciaFinal']);
Route::post('/storeCliente', [CadastroController::class, 'store']);
Route::post('/storeFarmacia', [CadastroController::class, 'storeFarmacia']);


Route::post('/home', [LoginController::class, 'entrar']);
Route::get('/home', [LoginController::class, 'pos_cad'])->name('login');

Route::get('/registrarProdutos', [RegistrarController::class, 'reg_prod'])->name('registrarProdutos');
Route::post('/registrarProdutos', [RegistrarController::class, 'store_prod'])->name('salvarProdutos');
Route::get('/registrarMarcas', [RegistrarController::class, 'reg_marcas'])->name('registrarMarcas');
Route::post('/registrarMarcas', [RegistrarController::class, 'store_marcas'])->name('salvarMarcas');
Route::get('/registrarCategorias', [RegistrarController::class, 'reg_categorias'])->name('registrarCategorias');
Route::post('/registrarCategorias', [RegistrarController::class, 'store_categorias'])->name('salvarCategorias');
Route::get('/registrarAdministradores', [RegistrarController::class, 'reg_administradores'])->name('registrarAdministradores');
Route::post('/registrarAdministradores/{id}', [RegistrarController::class, 'store_administradores'])->name('salvarAdministradores');
Route::post('/removerAdministradores/{id}', [RemoverController::class, 'destroy_administradores'])->name('removerAdministrador');
Route::post('/registrarEstoque/{id}', [RegistrarController::class, 'reg_estoque'])->name('registrarEstoque');
Route::post('/salvarEstoque/{id}', [RegistrarController::class, 'store_estoque'])->name('salvarEstoque');

Route::get('/listarProdutos', [ListarController::class, 'list_prod'])->name('listarProdutos');
Route::get('/listarMarcas', [ListarController::class, 'list_marcas'])->name('listarMarcas');
Route::get('/detalheProduto/{id}', [ListarController::class, 'detalhe_prod'])->name('detalheProduto');
Route::get('/listarEstoque/{id}', [ListarController::class, 'list_estoque'])->name('listarEstoque');

Route::post('/editarProduto/{id}', [EditarController::class, 'edit_prod'])->name('editarProduto');
Route::post('/editarMarca/{id}', [EditarController::class, 'edit_marca'])->name('editarMarca');
Route::get('/editarEstoque/{id}', [EditarController::class, 'edit_estoque'])->name('editarEstoque');
Route::post('/storeEditProduto/{id}', [EditarController::class, 'store_prod'])->name('salvarEditProduto');
Route::post('/storeEditMarca/{id}', [EditarController::class, 'store_marca'])->name('salvarEditMarca');
Route::post('/storeEditEstoque/{id}', [EditarController::class, 'store_estoque'])->name('salvarEditEstoque');

Route::post('/removerProduto/{id}', [EditarController::class, 'delete_prod'])->name('removerProduto');
Route::post('/removerEstoque/{id}', [EditarController::class, 'delete_estoque'])->name('removerEstoque');
Route::post('/removerMarca/{id}', [EditarController::class, 'delete_marca'])->name('removerEstoque');












Route::post('/teste', [LoginController::class, 'autenticacao']);
Route::get('/sair', function(){
    Auth::logout();
    return redirect('/');
});




