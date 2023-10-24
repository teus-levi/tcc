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
use Illuminate\Support\Facades\Storage;

class EditarController extends Controller
{
    public function edit_prod(Request $request){
        if(Auth::check()){
            $produto = DB::table('produtos')
                            ->join('categorias', 'categorias.id', '=', 'produtos.categoria')
                            ->join('marcas', 'marcas.id', '=', 'produtos.marca')
                            ->where('produtos.id', '=', $request->id)
                            ->select('produtos.*', 
                                    'categorias.nome as n_categoria', 'categorias.id as id_categoria',
                                    'marcas.nome as n_marca', 'marcas.id as id_marca')
                            ->get();
                                    
            $marcas = Marca::query()->orderBy('id')->get();
            $categorias = Categoria::query()->orderBy('id')->get();
            //$produto = Produto::find($request->id);
            //dd($produto);
            return view('editar.produto', compact('produto', 'marcas', 'categorias'));
        } else{
            return redirect('/home');
        }
    }

    public function store_prod(Request $request){
        if(Auth::check()){
            //$produto = Produto::find($request->id);
            //$validarImg = str_ireplace("produto/", "", $produto->imagem);
            //dd($request->hasFile('imagem'));

            if($request->hasFile('imagem')){
                $produto = Produto::find($request->id);
                Storage::delete($produto->imagem);
                $img = $request->file('imagem')->store('produto');
                $request->imagem = $img;
                //dd($request->all());
                Produto::where('id', $request->id)->update([
                    'nome' => $request->nome,
                    'imagem' => $request->imagem,
                    'precoVendaAtual' => $request->precoVenda,
                    'categoria' => $request->categoria,
                    'marca' => $request->marca,
                    'descricao' => $request->descricao
                ]);
                $request->session()->flash('mensagem', "Produto editado com sucesso!");
                return redirect()->route('listarProdutos');
            } else {
                Produto::where('id', $request->id)->update([
                    'nome' => $request->nome,
                    'precoVendaAtual' => $request->precoVenda,
                    'categoria' => $request->categoria,
                    'marca' => $request->marca,
                    'descricao' => $request->descricao
                ]);
                $request->session()->flash('mensagem', "Produto editado com sucesso!");
                //return redirect('/editarProduto/{{$request->id}}');
                $id = $request->id;

                return redirect()->route('editarProduto', [$id]);
            }

        } else{
            return redirect('login');
        }
    }

    public function delete_prod(Request $request){
        if(Auth::check()){
            $produto = Produto::find($request->id);
            if($produto){
                $estoque = Estoque::where('produto', $request->id)->get();
                if($estoque){
                    foreach ($estoque as $item) {
                        $item->delete();
                    }
                    $produto->delete();
                    $request->session()->flash('mensagem', "Produto e estoque deletado com sucesso!");
                    return redirect()->back();
                } else {
                $produto->delete();
                $request->session()->flash('mensagem', "Produto deletado com sucesso!");
                return redirect()->back();
                }
            }
        } else {
            return redirect('login');
        }
    }

    /* ESTOQUE */

    public function edit_estoque(Request $request){
        if(Auth::check()){
            //$estoque = Estoque::find($request->id);
            $estoque = DB::table('estoques')
                    ->join('produtos', 'estoques.produto', '=', 'produtos.id')    
                    ->where('estoques.id', '=', $request->id)
                    ->select('estoques.*', 'produtos.nome as n_produto')
                    ->get();                                
            return view('editar.estoque', compact('estoque'));
        } else{
            return redirect('/home');
        }
    }

    public function store_estoque(Request $request){
        if(Auth::check()){
            //$produto = Produto::find($request->id);
            //$validarImg = str_ireplace("produto/", "", $produto->imagem);
            //dd($request->hasFile('imagem'));
            /* FAZER VALIDAÇÃO DE NÃO EDITAR A QUANTIDADE PARA UM VALOR MENOR DO QUE FOI VENDIDO */
            if(true){
                $img = $request->file('imagem')->store('produto');
                $request->imagem = $img;
                //dd($request->all());
                Estoque::where('id', $request->id)->update([
                    'quantidade' => $request->quantidade,
                    'precoCompra' => $request->precoCompra,
                    'lote' => $request->lote,
                    'validade' => $request->validade,
                ]);
                $request->session()->flash('mensagem', "Estoque editado com sucesso!");
                return redirect('/editarEstoque/{{$request->id}}');
            } else {
                Produto::where('id', $request->id)->update([
                    'nome' => $request->nome,
                    'precoVendaAtual' => $request->precoVenda,
                    'categoria' => $request->categoria,
                    'marca' => $request->marca,
                    'descricao' => $request->descricao
                ]);
                $request->session()->flash('mensagem', "Produto editado com sucesso!");
                //return redirect('/editarProduto/{{$request->id}}');
                $id = $request->id;
                Route::post('/user/profile', function () {

                return redirect()->route('editarProduto', [$id]);
                });
            }

        } else{
            return redirect('login');
        }
    }

    public function delete_estoque(Request $request){
        if(Auth::check()){
            $estoque = Estoque::find($request->id);
            if($estoque){
                $estoque->delete();
                $request->session()->flash('mensagem', "Estoque deletado com sucesso!");
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }
}
