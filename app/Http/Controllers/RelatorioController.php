<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    public function filtro_estoque(){
        $filtros = [
            'status' => 3
        ];
        return view('relatorios.filtroEstoque', compact('filtros'));
    }

    public function relatorio_estoque(Request $request){
        $status = $request->status;
        if($status == 3){
            $produtos = DB::table('produtos')
                            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
                            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
                            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
                            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
                            ->groupBy('produtos.id')
                            ->orderBy('quantidade', 'asc')
                            ->orderBy('produtos.nome', 'asc')->get();
        } else if($status == 2){
            $produtos = DB::table('produtos')
                            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
                            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
                            ->whereNotNull('produtos.deleted_at')
                            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
                            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
                            ->groupBy('produtos.id')
                            ->orderBy('quantidade', 'asc')
                            ->orderBy('produtos.nome', 'asc')->get();
        } else {
            $produtos = DB::table('produtos')
                            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
                            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
                            ->whereNull('produtos.deleted_at')
                            ->select('produtos.*', DB::raw('SUM(estoques.quantidade) as quantidade'),
                            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
                            ->groupBy('produtos.id')
                            ->orderBy('quantidade', 'asc')
                            ->orderBy('produtos.nome', 'asc')->get();
        }
        $pdf = Pdf::loadView('relatorios.estoque', compact('produtos'));
        return $pdf->stream();
    }

    public function filtro_vendas(){
        $filtros = [
            'status' => 3
        ];

        return view('relatorios.filtroVendas', compact('filtros'));
    }

    public function relatorio_vendas(Request $request){
        $vendas = DB::table('produtos')
        ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
        ->join('marcas', 'marcas.id', '=', 'produtos.marca')
        ->join('itens_vendas', 'itens_vendas.produto', 'produtos.id')
        ->whereNull('itens_vendas.deleted_at')
        ->select('produtos.*', DB::raw('SUM(itens_vendas.quantidade) as quantidade'),
        'categorias.nome as n_categoria', 'marcas.nome as n_marca')
        ->groupBy('produtos.id')
        ->orderBy('quantidade', 'desc')
        ->orderBy('produtos.nome', 'asc')->get();

        $pdf = Pdf::loadView('relatorios.venda', compact('vendas'));
        return $pdf->stream();
    }

    public function filtro_produtos_vencidos(){
        $filtros = [
            'status' => 3
        ];

        return view('relatorios.filtroProdutos', compact('filtros'));
    }

    public function relatorio_produtos_vencidos(Request $request){
        $data = '2024-07';
        $vencidos = DB::table('produtos')
                            ->leftJoin('estoques', 'produtos.id', '=', 'estoques.produto')
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
                            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
                            ->whereNull('produtos.deleted_at')
                            ->whereNull('estoques.deleted_at')
                            ->whereNotNull('estoques.id')
                            ->where('estoques.validade', '>', $data)
                            ->select('produtos.*', 'estoques.id as estoque', 'estoques.validade',
                            'categorias.nome as n_categoria', 'marcas.nome as n_marca')
                            ->orderBy('estoques.validade', 'asc')
                            ->orderBy('produtos.nome', 'asc')->get();

        $pdf = Pdf::loadView('relatorios.vencidos', compact('vencidos'));
        return $pdf->stream();
    }
}
