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
use Illuminate\Support\Facades\Http;
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
                //Formatar valor para o banco
                $pontuacao = array(".", ",");
                $request->precoVenda = str_replace($pontuacao, "", $request->precoVenda);
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
                //Formatar valor para o banco
                $pontuacao = array(".", ",");
                $request->precoVenda = str_replace($pontuacao, "", $request->precoVenda);
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

                return redirect()->route('listarProdutos');
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
                //dd($request->all());
                //Formatar valor para o banco
                $pontuacao = array(".", ",");
                $request->precoCompra = str_replace($pontuacao, "", $request->precoCompra);
                //dd($request->all());
                $estoque = Estoque::find($request->id);
                //dd($estoque);
                Estoque::where('id', $request->id)->update([
                    'quantidade' => $request->quantidade,
                    'precoCompra' => $request->precoCompra,
                    'lote' => $request->lote,
                    'validade' => $request->validade,
                ]);
                
                $request->session()->flash('mensagem', "Estoque editado com sucesso!");
                return redirect()->route('listarEstoque', [$estoque->produto]);

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

    public function edit_marca(Request $request){
        if(Auth::check()){
        $marca = Marca::find($request->id);
        return view('editar.marcas', compact('marca'));
        } else {
            return redirect('login');
        }
    }
    public function store_marca(Request $request){
        if(Auth::check()){
            Marca::where('id', $request->id)->update([
                'nome' => $request->nome
            ]);
            $request->session()->flash('mensagem', "Marca editada com sucesso!");
            return redirect('/listarMarcas');
        } else {
            return redirect('login');
        }
    }

    public function delete_marca(Request $request){
        if(Auth::check()){
            $marca = Marca::find($request->id);
            if($marca){
                $marca->delete();
                $request->session()->flash('mensagem', "Marca deletada com sucesso!");
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    public function edit_categoria(Request $request){
        if(Auth::check()){
        $categoria = Categoria::find($request->id);
        return view('editar.categorias', compact('categoria'));
        } else {
            return redirect('login');
        }
    }
    public function store_categoria(Request $request){
        if(Auth::check()){
            Categoria::where('id', $request->id)->update([
                'nome' => $request->nome
            ]);
            $request->session()->flash('mensagem', "Categoria editada com sucesso!");
            return redirect('/listarCategorias');
        } else {
            return redirect('login');
        }
    }

    public function delete_categoria(Request $request){
        if(Auth::check()){
            $categoria = Categoria::find($request->id);
            if($categoria){
                $categoria->delete();
                $request->session()->flash('mensagem', "Categoria deletada com sucesso!");
                return redirect()->back();
            }
        } else {
            return redirect('login');
        }
    }

    public function confirmar_endereco(){
        return view('editar.confirmarEndereco');
    }
    public function edit_endereco(){
        if(Auth::check()){
            $id = Auth::id();
            $endereco = Cliente::where('usuario', $id)->get();
            return view('editar.endereco', compact('endereco'));
        } else {
            return redirect('login');
        }
    }
    public function store_endereco(Request $request){
        $id = Auth::id();
        if(Auth::check() && $id == $request->id){
            //formatando informações
            //dd($request->all());
            $cep = preg_replace("/[^0-9]/", "", $request->cep);
            $resposta = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
            $dadosApi = $resposta->json();
            if(!empty($dadosApi['erro'])){
                $request->session()->flash('erro', "O CEP está incorreto, por isso o endereço informado não foi salvo. Tente novamente.");
            } elseif(!empty($dadosApi['logradouro'])){
                //update no banco
                Cliente::where('usuario', $request->id)->update([
                    'CEP' => $cep,
                    'estado' => $dadosApi['uf'],
                    'cidade' => $dadosApi['localidade'],
                    'bairro' => $dadosApi['bairro'],
                    'logradouro' => $dadosApi['logradouro'],
                    'numero' => $request->numero
                ]);
                $request->session()->flash('mensagem', "Endereço editado com sucesso!");
            } else{
                if(is_null($request->logradouro)){
                    $request->session()->flash('erro', "Preencha o campo de logradouro!");
                } else{
                    //update no banco
                    Cliente::where('usuario', $request->id)->update([
                        'CEP' => $cep,
                        'estado' => $dadosApi['uf'],
                        'cidade' => $dadosApi['localidade'],
                        'bairro' => $request->bairro,
                        'logradouro' => $request->logradouro,
                        'numero' => $request->numero
                    ]);
                    $request->session()->flash('mensagem', "Endereço editado com sucesso!");
                }
                
            }
            return redirect('/endereco');
        } else {
            return redirect('login');
        }
    }
    public function edit_senha(){
        if(Auth::check()){
            return view('editar.senha');
        } else{
            return redirect('login');
        }
    }

    public function store_senha(Request $request){
        if(Auth::check()){
            //validando informações
            //dd($request->all());
            if (!Auth::attempt($request->only('password'))){
                $request->session()->flash('erro', "A senha não condiz com a senha atual.");
                return redirect('/senha');
            } elseif($request->senhaNova == $request->confirmarSenha) {
                //update no banco
                $id = Auth::id();
                $senha = Hash::make($request->senhaNova);
                User::where('id', $id)->update([
                    'password' => $senha
                ]);
                $request->session()->flash('mensagem', "Senha editada com sucesso!");
                return redirect('/senha');
            }else {
                $request->session()->flash('erro', "A confirmação da senha não condiz com a nova senha.");
                return redirect('/senha');
            }
            
        } else {
            return redirect('login');
        }
    }

    public function edit_perfil(){
        if(Auth::check()){
            $id = Auth::id();
            $perfil = DB::table('users')
            ->join('clientes', 'users.id', '=', 'clientes.usuario')
            ->where('users.id', '=', $id)
            ->select('users.name', 'clientes.*')
            ->get();
            return view('editar.perfil', compact('perfil'));
        } else {
            return redirect('login');
        }
    }

    public function store_perfil(Request $request){
        $id = Auth::id();
        if(Auth::check() && $id == $request->id){
            //formatando informações
            //dd($request->all());
            $cpf = array(".", "-");
            $request->CPF = str_replace($cpf, "", $request->CPF);
            $telefone = array("(", ")", "-", " ");
            $request->telefone = str_replace($telefone, "", $request->telefone);
            //update no banco
            Cliente::where('usuario', $request->id)->update([
                'CPF' => $request->CPF,
                'telefone' => $request->telefone,
                'dataNascimento' => $request->dataNascimento
            ]);
            User::where('id', $request->id)->update([
                'name' => $request->nome
            ]);
            $request->session()->flash('mensagem', "Perfil editado com sucesso!");
            return redirect('/perfil');
        } else {
            return redirect('login');
        }
    }

}
