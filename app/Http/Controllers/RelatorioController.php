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
        return view('relatorios.filtroEstoque');
    }

    public function filtro_produtos_vencidos(){
        return view('relatorios.filtroEstoque');
    }
}
