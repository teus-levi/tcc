<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use App\Models\Estoque;
use App\Models\Venda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListarController extends Controller
{
    /*
    public function __construct(){
        $this->middleware('auth');
    }*/

    public function list_prod(){
        if(Auth::check()){
            //Se tem ou não o estoque do produto
            /*$estoque = DB::table('produtos')
                            ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->orderBy('produtos.nome')
                            ->get();
            */
            /*
            $estoque = DB::select('select produtos.* from produtos
                                    where produtos.id = estoques.produto');

            $produtos = Produto::query()->orderBy('id')->get();

            $produtos = $produtos->diff($estoque);
            */

            /*
            $produtos = DB::select('select produtos.*, estoques.produto, estoques.quantidade from produtos
                                    left join estoques
                                    on produtos.id = estoques.produto')->paginate(10);
                                    */

            $produtos = DB::table('produtos')
                            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
                            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
                            ->whereNull('produtos.deleted_at')
                            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
                            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
                            ->groupBy('produtos.id')
                            ->orderBy('quantidade', 'asc')
                            ->orderBy('produtos.nome', 'asc')
                            ->paginate(10);
            //dd($produtos);

            $filtros = ['periodo' => 9999, 'ordenacao' => 1, 'classificacao' => 1];

            return view('listar.produtos', compact('produtos', 'filtros'));
        } else{
            return redirect('/home');
        }
    }

    public function list_estoque(Request $request){
        //$estoque = Estoque::query()->orderBy('id')->get();

        $est = DB::table('estoques')
        ->join('produtos', 'produtos.id', '=', 'estoques.produto')
        ->where('estoques.produto', '=', $request->id)
        ->select('estoques.*', 'produtos.nome as n_produto')
        ->orderBy('estoques.id', 'desc')->paginate(10);
        foreach ($est as $item) {
            if(!is_null($item)){
                return view('listar.estoque', compact('est'));
            }
            return redirect('/');
        }


    }

    public function detalhe_prod(Request $request){
            //$produto = Produto::find($request->id);
            $produto = DB::table('produtos')
                    ->join('marcas', 'produtos.marca', '=', 'marcas.id')
                    ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                    ->whereNull('estoques.deleted_at')
                    ->whereNull('produtos.deleted_at')
                    ->where('produtos.id', '=', $request->id)
                    ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'), 'marcas.nome as n_marca')
                    ->groupBy('produtos.id')
                    ->get();
            $produtosCategoria = DB::table('produtos')
                    ->join('categorias', 'produtos.categoria', '=', 'categorias.id')
                    ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                    ->whereNull('estoques.deleted_at')
                    ->whereNull('produtos.deleted_at')
                    ->where('produtos.categoria', '=', $produto[0]->categoria)
                    ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'))
                    ->groupBy('produtos.id')
                    ->orderBy('categorias.id')
                    ->get();
            return view('listar.detalheProduto', compact('produto', 'produtosCategoria'));
    }

    public function list_marcas(){
        $marcas = Marca::query()->OrderBy('id')->paginate(10);
        $periodo = 9999;
        $ordenacao = 1;
        $filtros = ['periodo' => $periodo, 'ordenacao' => $ordenacao, 'classificacao' => 1];

        return view('listar.marcas', compact('marcas', 'filtros'));
    }

    public function list_filt_marcas(Request $request){
        $ordenacao = $request->ordenacao;
        $periodo = $request->periodo;
        $filtros = $request->except('_token');
        $pesquisa = $request->pesquisa;

        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d H:i:s');
        $segundosAtual = strtotime($dataAtual);
        $dataLimite = date("Y-m-d H:i:s", ($segundosAtual - ($periodo * 86400)));

        if ($ordenacao == 1){
            $ordenacao = 'desc';
        } else{
            $ordenacao = 'asc';
        }

        if($periodo == 9999){
            $dataLimite = 0;
        }

        if($request->classificacao == 1){
            $marcas = DB::table('marcas')
            ->whereNull('marcas.deleted_at')
            ->where('marcas.created_at', '>=', $dataLimite)
            ->where('marcas.nome', 'like', '%'. $pesquisa . '%')
            ->select('marcas.*')
            ->orderBy('marcas.nome', $ordenacao)->paginate(10);

            return view('listar.marcas', compact('marcas', 'filtros'));
        } else if($request->classificacao == 2) {
            $marcas = DB::table('marcas')
            ->whereNotNull('marcas.deleted_at')
            ->where('marcas.created_at', '>=', $dataLimite)
            ->where('marcas.nome', 'like', '%'. $pesquisa . '%')
            ->select('marcas.*')
            ->orderBy('marcas.created_at', $ordenacao)->paginate(10);

            return view('listar.marcas', compact('marcas', 'filtros'));
        } else {
            $marcas = DB::table('marcas')
            ->where('marcas.created_at', '>=', $dataLimite)
            ->where('marcas.nome', 'like', '%'. $pesquisa . '%')
            ->select('marcas.*')
            ->orderBy('marcas.created_at', $ordenacao)->paginate(10);

            return view('listar.marcas', compact('marcas', 'filtros'));
        }
    }

    public function list_categorias(){
        $categorias = Categoria::query()->OrderBy('id')->paginate(10);

        $periodo = 9999;
        $ordenacao = 1;
        $filtros = ['periodo' => $periodo, 'ordenacao' => $ordenacao, 'classificacao' => 1];

        return view('listar.categorias', compact('categorias', 'filtros'));
    }

    public function list_filt_categorias(Request $request){
        $ordenacao = $request->ordenacao;
        $periodo = $request->periodo;
        $filtros = $request->except('_token');
        $pesquisa = $request->pesquisa;

        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d H:i:s');
        $segundosAtual = strtotime($dataAtual);
        $dataLimite = date("Y-m-d H:i:s", ($segundosAtual - ($periodo * 86400)));

        if ($ordenacao == 1){
            $ordenacao = 'desc';
        } else{
            $ordenacao = 'asc';
        }

        if($periodo == 9999){
            $dataLimite = 0;
        }

        if($request->classificacao == 1){
            $categorias = DB::table('categorias')
            ->whereNull('categorias.deleted_at')
            ->where('categorias.created_at', '>=', $dataLimite)
            ->where('categorias.nome', 'like', '%'. $pesquisa . '%')
            ->select('categorias.*')
            ->orderBy('categorias.created_at', $ordenacao)->paginate(10);

            return view('listar.categorias', compact('categorias', 'filtros'));
        } else if($request->classificacao == 2){
            $categorias = DB::table('categorias')
            ->whereNotNull('categorias.deleted_at')
            ->where('categorias.created_at', '>=', $dataLimite)
            ->where('categorias.nome', 'like', '%'. $pesquisa . '%')
            ->select('categorias.*')
            ->orderBy('categorias.created_at', $ordenacao)->paginate(10);

            return view('listar.categorias', compact('categorias', 'filtros'));
        } else {
            $categorias = DB::table('categorias')
            ->where('categorias.created_at', '>=', $dataLimite)
            ->where('categorias.nome', 'like', '%'. $pesquisa . '%')
            ->select('categorias.*')
            ->orderBy('categorias.created_at', $ordenacao)->paginate(10);

            return view('listar.categorias', compact('categorias', 'filtros'));
        }
    }

    public function list_carrinho(){
        return view('listar.carrinho');
    }

    public function list_compra(Request $request){
        $produto = Produto::find($request->produto);
        $marca = Marca::find($produto->marca);

        $cart = session()->get('cart', []);
        if(isset($cart[$request->produto])){
            $cart[$request->produto]['quantidade']++;

        } else {
            $cart[$request->produto] = [
                "id" => $produto->id,
                "nome" => $produto->nome,
                "marca" => $marca->nome,
                "quantidade" => 1,
                "preco" => $produto->precoVendaAtual,
                "imagem" => $produto->imagem
            ];
        }
        session()->put('cart', $cart);
        return view('listar.carrinho');
    }

    public function list_pedidos(){
        $periodo = 9999;
        $ordenacao = 1;
        $filtros = ['periodo' => $periodo, 'ordenacao' => $ordenacao];
        $cliente = Cliente::where('usuario', '=', Auth::id())->get();
        if(!isset($cliente)){
            return redirect()->route('login');
        }
        $pedidos = DB::table('vendas')
                        ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                        ->where('vendas.cliente', '=', $cliente[0]->id)
                        ->select('vendas.*')
                        ->groupBy('vendas.id')
                        ->orderBy('vendas.created_at', 'desc')
                        ->paginate(5);

        $itensPedidos = DB::table('vendas')
                        ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                        ->join('produtos', 'produtos.id', '=', 'itens_vendas.produto')
                        ->where('vendas.cliente', '=', $cliente[0]->id)
                        ->select('itens_vendas.*', 'produtos.id', 'produtos.nome')
                        ->orderBy('itens_vendas.venda')
                        ->get();
        return view('listar.pedidos', compact('pedidos', 'itensPedidos', 'filtros'));
    }

    public function list_detalhes_ped(Request $request){
        $id = $request->id;
        //dd($id);
        $cliente = Cliente::where('usuario', '=', Auth::id())->get();

        $pedido = Venda::withTrashed()->find($id);

        //dd($cliente[0]->id);

        if($pedido->cliente == $cliente[0]->id){
            return view('listar.pedidoDetalhado', compact('pedido'));
        } else {
            $request->session()->flash('erro', "Usuário inválido para o processo.");
            return redirect('/home');
        }

    }

    public function list_pagamento(Request $request){
        $itens = $request->except('_token');

        $cep = preg_replace("/[^0-9]/", "", $request->cep);
        $resposta = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
        $dadosApi = $resposta->json();

        if(!empty($dadosApi['erro'])){
            $request->session()->flash('erro', "O CEP está incorreto, por isso o endereço informado não foi salvo. Tente novamente.");
            return redirect('/confirmarEndereco');
        }else if($dadosApi['localidade'] != "Umuarama"){
            $request->session()->flash('erro', "No momento atendemos apenas a cidade de Umuarama. Em breve teremos novas localidades.");
            return redirect('/confirmarEndereco');
        } else{
            if(is_null($request->logradouro)){
                $request->session()->flash('erro', "Preencha o campo de logradouro!");
                return redirect('/confirmarEndereco');
            } else if(is_null($request->bairro)){
                $request->session()->flash('erro', "Preencha o campo do bairro!");
                return redirect('/confirmarEndereco');
            } else {
                $request->session()->put('compra', $itens);

                return view('listar.formaPagamento');
            }

        }

    }

    public function list_filt_pedidos(Request $request){
        $periodo = $request->periodo;
        $ordenacao = $request->ordenacao;
        $filtros = $request->except('_token');
        $filtro = "desc";
        $id = Auth::id();

        if($ordenacao == 2){
            $filtro = "asc";
        }

        if($periodo == 9999){
            $pedidos = DB::table('vendas')
                        ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                        ->whereNull('vendas.deleted_at')
                        ->whereNull('itens_vendas.deleted_at')
                        ->where('vendas.cliente', '=', $id)
                        ->select('vendas.*')
                        ->groupBy('vendas.id')
                        ->orderBy('vendas.created_at', $filtro)
                        ->paginate(5);

            $itensPedidos = DB::table('vendas')
                            ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                            ->join('produtos', 'produtos.id', '=', 'itens_vendas.produto')
                            ->whereNull('vendas.deleted_at')
                            ->whereNull('itens_vendas.deleted_at')
                            ->where('vendas.cliente', '=', $id)
                            ->select('itens_vendas.*', 'produtos.id', 'produtos.nome')
                            ->orderBy('itens_vendas.venda')
                            ->get();

        return view('listar.pedidos', compact('pedidos', 'itensPedidos', 'filtros'));

        } else {
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('Y-m-d H:i:s');
            $segundosAtual = strtotime($dataAtual);
            $dataLimite = date("Y-m-d H:i:s", ($segundosAtual - ($periodo * 86400)));

            $pedidos = DB::table('vendas')
                            ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                            ->whereNull('vendas.deleted_at')
                            ->whereNull('itens_vendas.deleted_at')
                            ->where('vendas.cliente', '=', $id)
                            ->where('vendas.created_at', '>=', $dataLimite)
                            ->select('vendas.*')
                            ->groupBy('vendas.id')
                            ->orderBy('vendas.created_at', $filtro)
                            ->paginate(5);

            $itensPedidos = DB::table('vendas')
                            ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                            ->join('produtos', 'produtos.id', '=', 'itens_vendas.produto')
                            ->where('vendas.cliente', '=', $id)
                            ->whereNull('vendas.deleted_at')
                            ->whereNull('itens_vendas.deleted_at')
                            ->select('itens_vendas.*', 'produtos.id', 'produtos.nome')
                            ->orderBy('itens_vendas.venda')
                            ->get();

            return view('listar.pedidos', compact('pedidos', 'itensPedidos', 'filtros'));
        }
    }

    public function list_filt_home(Request $request) {
        $ordenacao = $request->ordenacao;
        $ordenacao2 = '';
        $filtros = $request->except('_token');
        $pesquisa = $request->pesquisa;

        if ($ordenacao == 1){
            $ordenacao = 'produtos.nome';
            $ordenacao2 = 'asc';
            $filtros['ordenacao'] = 1;
        } else if($ordenacao == 2){
            $ordenacao =  'produtos.precoVendaAtual';
            $ordenacao2 = 'asc';
            $filtros['ordenacao'] = 2;
        } else{
            $ordenacao = 'produtos.precoVendaAtual';
            $ordenacao2 = 'desc';
            $filtros['ordenacao'] = 3;
        }

        if(isset($pesquisa)){
            $produtos = DB::table('produtos')
                        ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                        ->join('marcas', 'produtos.marca', '=', 'marcas.id')
                        ->join('categorias', 'produtos.categoria', '=', 'categorias.id')
                        ->whereNull('produtos.deleted_at')
                        ->whereNull('estoques.deleted_at')
                        ->whereNull('categorias.deleted_at')
                        ->whereNull('marcas.deleted_at')
                        ->where('produtos.nome', 'like', '%'.$pesquisa.'%')
                        ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'))
                        ->groupBy('produtos.id')
                        ->orderBy($ordenacao, $ordenacao2)->paginate(6);
            $carrinho = true;
            return view('principal.index', compact('produtos', 'carrinho', 'filtros', 'pesquisa'));
        } else {
            $produtos = DB::table('produtos')
                            ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->join('marcas', 'produtos.marca', '=', 'marcas.id')
                            ->join('categorias', 'produtos.categoria', '=', 'categorias.id')
                            ->whereNull('produtos.deleted_at')
                            ->whereNull('estoques.deleted_at')
                            ->whereNull('categorias.deleted_at')
                            ->whereNull('marcas.deleted_at')
                            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'))
                            ->groupBy('produtos.id')
                            ->orderBy($ordenacao, $ordenacao2)->paginate(6);
                $carrinho = true;
                return view('principal.index', compact('produtos', 'carrinho', 'filtros'));
        }
    }

    public function list_vendas(){
        $filtros = ['periodo' => 9999, 'ordenacao' => 1];

        $vendas = Venda::withTrashed()->orderBy('id', 'desc')->paginate(10);
        return view('listar.vendas', compact('vendas', 'filtros'));
    }

    public function list_filt_vendas(Request $request){
        $ordenacao = $request->ordenacao;
        $periodo = $request->periodo;
        $filtros = $request->except('_token');
        $pesquisa = $request->pesquisa;

        if ($ordenacao == 1){
            $ordenacao = 'desc';
        } else{
            $ordenacao = 'asc';
        }

        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d H:i:s');
        $segundosAtual = strtotime($dataAtual);
        $dataLimite = date("Y-m-d H:i:s", ($segundosAtual - ($periodo * 86400)));

        if(isset($pesquisa) && $periodo == 9999){
            $vendas = Venda::withTrashed()
                        ->where('vendas.nomeRecebedor', 'like', '%'.$pesquisa.'%')
                        ->orderBy('id', $ordenacao)->paginate(10);
            return view('listar.vendas', compact('vendas', 'filtros', 'pesquisa'));
        } else if($periodo == 9999){
            $vendas = Venda::withTrashed()
                        ->orderBy('id', $ordenacao)->paginate(10);
            return view('listar.vendas', compact('vendas', 'filtros', 'pesquisa'));
        } else if(isset($pesquisa)){
            $vendas = Venda::withTrashed()
            ->where('vendas.nomeRecebedor', 'like', '%'.$pesquisa.'%')
            ->where('vendas.created_at', '>=', $dataLimite)
            ->orderBy('id', $ordenacao)->paginate(10);
            return view('listar.vendas', compact('vendas', 'filtros', 'pesquisa'));
        } else {
            $vendas = Venda::withTrashed()
            ->where('vendas.created_at', '>=', $dataLimite)
            ->orderBy('id', $ordenacao)->paginate(10);
            return view('listar.vendas', compact('vendas', 'filtros', 'pesquisa'));
        }

    }

    public function list_filt_prod(Request $request){
        $ordenacao = $request->ordenacao;
        $periodo = $request->periodo;
        $filtros = $request->except('_token');
        $pesquisa = $request->pesquisa;
        $classificacao = $request->classificacao;

        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d H:i:s');
        $segundosAtual = strtotime($dataAtual);
        $dataLimite = date("Y-m-d H:i:s", ($segundosAtual - ($periodo * 86400)));

        if ($ordenacao == 1){
            $ordenacao = 'desc';
        } else{
            $ordenacao = 'asc';
        }

        if($periodo == 9999){
            $dataLimite = 0;
        }

        /*if($classificacao == 1){
            $classificacao = '->whereNull('deleted_at');';
        } else if($classificacao == 2){
            $classificacao = '->whereNotNull('deleted_at');';
        } else {
            $classificacao = '->withTrashed();';
        }*/


        if(isset($pesquisa) && $classificacao == 1){
            $produtos = DB::table('produtos')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
            ->whereNull('produtos.deleted_at')
            ->where('produtos.created_at', '>=', $dataLimite)
            ->where('produtos.nome', 'like', '%'. $pesquisa . '%')
            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
            ->groupBy('produtos.id')
            ->orderBy('produtos.nome', $ordenacao)->paginate(10);

            return view('listar.produtos', compact('produtos', 'filtros'));
        } else if(isset($pesquisa) && $classificacao == 2){
            $produtos = DB::table('produtos')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
            ->whereNotNull('produtos.deleted_at')
            ->where('produtos.created_at', '>=', $dataLimite)
            ->where('produtos.nome', 'like', '%'. $pesquisa . '%')
            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
            ->groupBy('produtos.id')
            ->orderBy('produtos.nome', $ordenacao)->paginate(10);

            return view('listar.produtos', compact('produtos', 'filtros'));

        }else if(isset($pesquisa) && $classificacao == 3){
            $produtos = DB::table('produtos')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
            ->where('produtos.created_at', '>=', $dataLimite)
            ->where('produtos.nome', 'like', '%'. $pesquisa . '%')
            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
            ->groupBy('produtos.id')
            ->orderBy('produtos.nome', $ordenacao)->paginate(10);

            return view('listar.produtos', compact('produtos', 'filtros'));

        } else if($classificacao == 1){
            $produtos = DB::table('produtos')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
            ->whereNull('produtos.deleted_at')
            ->where('produtos.created_at', '>=', $dataLimite)
            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
            ->groupBy('produtos.id')
            ->orderBy('produtos.nome', $ordenacao)->paginate(10);

            return view('listar.produtos', compact('produtos', 'filtros'));
        } else if($classificacao == 2){
            $produtos = DB::table('produtos')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
            ->whereNotNull('produtos.deleted_at')
            ->where('produtos.created_at', '>=', $dataLimite)
            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
            ->groupBy('produtos.id')
            ->orderBy('produtos.nome', $ordenacao)->paginate(10);

            return view('listar.produtos', compact('produtos', 'filtros'));

        } else {
            $produtos = DB::table('produtos')
            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
            ->where('produtos.created_at', '>=', $dataLimite)
            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
            ->groupBy('produtos.id')
            ->orderBy('produtos.nome', $ordenacao)->paginate(10);

            return view('listar.produtos', compact('produtos', 'filtros'));

        }


    }

    public function list_fechar_pedido(Request $request){
        $venda = Venda::find($request->id);
        return view('listar.fecharPedido', compact('venda'));
    }

    public function list_filt_adm(Request $request){
        $ordenacao = 'asc';
        $pesquisa = $request->pesquisa;

        $filtros = ['pesquisa' => $pesquisa];


        if(isset($pesquisa)){
            $usuarios = DB::table('users')
            ->whereNull('users.deleted_at')
            ->where('users.name', 'like', '%'. $pesquisa . '%')
            ->orWhere('users.email', 'like', '%'. $pesquisa . '%')
            ->whereNull('users.deleted_at')
            ->select('users.*')
            ->orderBy('users.name', $ordenacao)->paginate(10);
            $filtro['pesquisa'] = $pesquisa;
            return view('registros.administradores', compact('usuarios', 'filtros'));

        } else {
            $usuarios = DB::table('users')
            ->whereNull('users.deleted_at')
            ->select('users.*')
            ->orderBy('users.name', $ordenacao)->paginate(10);

            return view('registros.administradores', compact('usuarios', 'filtros'));
        }
    }

}
