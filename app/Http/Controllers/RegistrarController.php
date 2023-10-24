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




class RegistrarController extends Controller
{
    public function reg_prod(){
        if(Auth::check()){
            $marcas = Marca::query()->orderBy('id')->get();
            $categorias = Categoria::query()->orderBy('id')->get();


            return view('registros.produtosFarmacia', compact('marcas', 'categorias'));
        } else{
            return redirect('/home');
        }
        
    }

    public function store_prod(Request $request){
        //dd($request->all());
        if($request->hasFile('imagem')){
            $dados = $request->all();
            foreach ($dados as $dado) {
                if(is_null($dado)){
                    $request->session()->flash('erro', "Todos os campos devem ser preenchidos!");
                    return redirect('registrarProdutos');
                }
                
            }
            //salva a imagem em storage, na pasta produto
            $img = $request->file('imagem')->store('produto');

            $user = Auth::user();
            $dados = $request->all();
            $dados += ["administrador" => $user->id];

            $dados["imagem"] = $img;

            //Formatar valor para o banco
            $pontuacao = array(".", ",");
            $dados['precoVendaAtual'] = str_replace($pontuacao, "", $dados['precoVendaAtual']);

            //dd($dados);
            Produto::create($dados);
            $request->session()->flash('mensagem', "Produto registrado com sucesso!");
            return redirect('registrarProdutos');
        }else {
            $request->session()->flash('erro', "Imagem deve ser selecionada!");
            return redirect('registrarProdutos');
        }
    }

    public function reg_marcas(){
        if(Auth::check()){            
            return view('registros.marcasFarmacia');
        } else{
            return redirect('/home');
        }
        
    }

    public function store_marcas(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $dados = $request->all();
            $dados += ["administrador" => $user->id];
            //dd($dados);
            Marca::create($dados);
            $request->session()->flash('mensagem', "Marca registrada com sucesso!");
            return redirect('registrarMarcas');

        } else{
            return redirect('registrarMarcas');
        }
    }

    public function reg_categorias(){
        if(Auth::check()){            
            return view('registros.categoriasFarmacia');
        } else{
            return redirect('/home');
        }
        
    }

    public function store_categorias(Request $request){
        if(Auth::check()){
            $user = Auth::user();
            $dados = $request->all();
            $dados += ["administrador" => $user->id];
            //dd($dados);
            Categoria::create($dados);
            $request->session()->flash('mensagem', "Categoria registrada com sucesso!");
            return redirect('registrarCategorias');

        } else{
            return redirect('registrarCategorias');
        }
    }

    public function reg_administradores(){
        if(Auth::check()){            
            $usuarios = User::query()->orderBy('id')->get();
            return view('registros.administradores', compact('usuarios'));

        } else{
            return redirect('/home');
        }
        
    }

    public function store_administradores(Request $request){
        if(Auth::check()){
            User::where('id', $request->id)->update([
                'administrador' => 1
            ]);
            $request->session()->flash('mensagem', "Administrador registrado com sucesso!");
            return redirect('registrarAdministradores');

        } else{
            return redirect('registrarAdministradores');
        }
    }

    public function reg_estoque(Request $request){
        if(Auth::check()){    
            $produto = Produto::find($request->id);
            return view('registros.estoque', compact('produto'));
        } else{
            return redirect('/home');
        }
    }

    public function store_estoque(Request $request){
        if(Auth::check()){
            $dados = $request->all();
            foreach ($dados as $dado) {
                if(is_null($dado)){
                    $request->session()->flash('erro', "Todos os campos devem ser preenchidos!");
                    return redirect('/registrarEstoque/{{$request->id}}');
                }
                
            }
            $dados["produto"] = $request->id;
            //dd($dados);
            //Formatando preco
            $pontuacao = array(".", ",");
            $dados['precoCompra'] = str_replace($pontuacao, "", $dados['precoCompra']);
            Estoque::create($dados);
            $request->session()->flash('mensagem', "Estoque registrado com sucesso!");
            return redirect('listarProdutos');
        }
    }

}