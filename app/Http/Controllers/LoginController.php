<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class LoginController extends Controller
{
    public function login(){
        session_start();

            return view('login.index');
        }



    public function autenticacao(Request $request){
        $email = $request->email;
        $senha = $request->senha;
        if(empty($email) && empty($senha)){
            return redirect('/');
        }else {
        $dados = [$request->email, $request->senha];
        $autenticacao = 0;
            //dd($dados);
            //pegando informações dos clientes registrados
            $clientes = Cliente::query()->orderBy('codigo')->get();
            //dd($clientes);
            foreach($clientes as $cliente){
                if($cliente->email == $email && $cliente->senha == $senha){
                    //return redirect('/teste');
                    $autenticacao = 1;
                    return view('principal.index', compact('produtos'));
                }
            }
            if($autenticacao == 0){
                return redirect('/');
            }
        }
    }

    public function entrar(Request $request){
        //true or false

        //dd($request);
        if (!Auth::attempt($request->only('email', 'password'))){
            $request->session()->flash('erro', "Usuário/Senha inválido(s)");
            return redirect()->route('login');
        }
        /*
            $produtos = DB::table('produtos')
                ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                ->select('produtos.*', 'estoques.quantidade')
                ->paginate(6);
                */
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
                ->orderBy('produtos.nome', 'asc')->paginate(6);
                $carrinho = true;
                $filtros['ordenacao'] = 1; //ordenar pelo nome
            return view('principal.index', compact('produtos', 'carrinho', 'filtros'));

    }

    public function pos_cad(){
            //$produtos = Produto::paginate(6);
            /*
            $produtos = DB::table('produtos')
                        ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                        ->select('produtos.*', 'estoques.quantidade')
                        ->paginate(6);
                        */
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
                        ->orderBy('produtos.nome', 'asc')->paginate(6);
            $carrinho = true;
            $filtros['ordenacao'] = 1;
            return view('principal.index', compact('produtos', 'carrinho', 'filtros'));

    }

}
