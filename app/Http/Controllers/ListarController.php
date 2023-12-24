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
                            ->orderBy('quantidade', 'asc')->paginate(10);
            //dd($produtos);

            return view('listar.produtos', compact('produtos'));
        } else{
            return redirect('/home');
        }
    }

    public function list_estoque(Request $request){
        //$estoque = Estoque::query()->orderBy('id')->get();
        $est = DB::table('estoques')
        ->join('produtos', 'produtos.id', '=', 'estoques.produto')
        ->whereNull('estoques.deleted_at')
        ->whereNull('produtos.deleted_at')
        ->where('estoques.produto', '=', $request->id)
        ->select('estoques.*', 'produtos.nome as n_produto')
        ->orderBy('estoques.id', 'desc')->get();
        foreach ($est as $item) {
            if(!is_null($item)){
                return view('listar.estoque', compact('est'));
            }
            return redirect('/');
        }
        

    }

    public function detalhe_prod(Request $request){
        if(Auth::check()){
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
    }

    public function list_marcas(){
        $marcas = Marca::query()->OrderBy('id')->paginate(10);
        return view('listar.marcas', compact('marcas'));
    }

    public function list_categorias(){
        $categorias = Categoria::query()->OrderBy('id')->paginate(10);
        return view('listar.categorias', compact('categorias'));
    }

    public function list_carrinho(){
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
                        ->whereNull('vendas.deleted_at')
                        ->whereNull('itens_vendas.deleted_at')
                        ->where('vendas.cliente', '=', $cliente[0]->id)
                        ->select('vendas.*')
                        ->groupBy('vendas.id')
                        ->orderBy('vendas.created_at', 'desc')
                        ->paginate(5);
                        
        $itensPedidos = DB::table('vendas')
                        ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                        ->join('produtos', 'produtos.id', '=', 'itens_vendas.produto')
                        ->whereNull('vendas.deleted_at')
                        ->whereNull('itens_vendas.deleted_at')
                        ->where('vendas.cliente', '=', $cliente[0]->id)
                        ->select('itens_vendas.*', 'produtos.id', 'produtos.nome')
                        ->orderBy('itens_vendas.venda')
                        ->get();
        return view('listar.pedidos', compact('pedidos', 'itensPedidos', 'filtros'));
    }

    public function list_pagamento(Request $request){
        $itens = $request->except('_token');
        $request->session()->put('compra', $itens);
        
        return view('listar.formaPagamento');
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

    public function list_fechar_pedido(Request $request){
        $venda = Venda::find($request->id);
        return view('listar.fecharPedido', compact('venda'));
    }

}
