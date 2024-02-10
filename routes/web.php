<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CadastroController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\RemoverController;
use App\Http\Controllers\ListarController;
use App\Http\Controllers\EditarController;
use App\Http\Controllers\Mails\SendMails;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

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
Route::get('/cadastrar2', [CadastroController::class, 'user']);
//Route::post('/cadastrar3', [CadastroController::class, 'farmaciaFinal']);
Route::post('/storeCliente', [CadastroController::class, 'store']);

//Route::post('/storeFarmacia', [CadastroController::class, 'storeFarmacia']);


Route::post('/home', [LoginController::class, 'entrar']);
Route::get('/home', [LoginController::class, 'pos_cad'])->name('home');

Route::get('/recuperar-senha', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

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
    //Route::get('/fecharPedido/{id}', [ListarController::class, 'list_fechar_pedido'])->name('fecharPedido');

    Route::get('/pedidos', [ListarController::class, 'list_pedidos'])->name('listarPedidos');
    Route::get('/detalhesPedido/{id}', [ListarController::class, 'list_detalhes_ped'])->name('listarDetalhesPedido');
    Route::get('/formaPagamento', [ListarController::class, 'list_pagamento'])->name('formaPagamento');
    Route::any('/filtrarPedidos', [ListarController::class, 'list_filt_pedidos'])->name('filtrarPedidos');
    Route::any('/filtrarVendas', [ListarController::class, 'list_filt_vendas'])->name('filtrarVendas')->middleware('can:administrador');
    Route::any('/filtrarProdutos', [ListarController::class, 'list_filt_prod'])->name('filtrarProdutos')->middleware('can:administrador');
    Route::any('/filtrarMarcas', [ListarController::class, 'list_filt_marcas'])->name('filtrarMarcas')->middleware('can:administrador');
    Route::any('/filtrarCategorias', [ListarController::class, 'list_filt_categorias'])->name('filtrarCategorias')->middleware('can:administrador');
    Route::any('/filtrarAdministradores', [ListarController::class, 'list_filt_adm'])->name('filtrarAdministradores')->middleware('can:administrador');

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
    Route::post('/storeEditPedido/{id}', [EditarController::class, 'store_pedido'])->name('salvarEditVenda')->middleware('can:administrador');
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
    Route::post('/removerVenda/{id}', [EditarController::class, 'cancelar_venda'])->name('removerVenda')->middleware('can:administrador');
    //Route::delete('/removerVenda/{id}', ['as' => 'venda.delete', 'vendas' => 'EditController@cancelar_venda'])->middleware('can:administrador');


    Route::get('/enviar-email', [SendMails::class, 'sendMail'])->name('sendMail')->middleware('can:administrador');

    Route::get('/relatorio/estoque', [RelatorioController::class, 'filtro_estoque'])->name('relatorioEstoque')->middleware('can:administrador');
});


Route::get('/carrinho', [ListarController::class, 'list_carrinho'])->name('listarCarrinho');
Route::get('/comprar', [ListarController::class, 'list_compra'])->name('listarCompra');
Route::get('/detalheProduto/{id}', [ListarController::class, 'detalhe_prod'])->name('detalheProduto');
Route::any('/filtrarHome', [ListarController::class, 'list_filt_home'])->name('filtrarHome');








Route::post('/teste', [LoginController::class, 'autenticacao']);
Route::get('/sair', function(){
    session()->flush();
    Auth::logout();
    return redirect('/');
});




