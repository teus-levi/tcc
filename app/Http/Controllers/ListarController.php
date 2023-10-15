<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use App\Models\Estoque;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListarController extends Controller
{
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
                            ->orderBy('estoques.produto', 'asc')->paginate(10);
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
        ->where('estoques.produto', '=', $request->id)
        ->select('estoques.*', 'produtos.nome as n_produto')
        ->orderBy('estoques.id', 'desc')->get();
        return view('listar.estoque', compact('est'));
    }

}
