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
            return redirect()->back()->withErrors('Usuário/Senha inválido(s)');
        }
            $produtos = DB::table('produtos')
                ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                ->select('produtos.*', 'estoques.quantidade')
                ->paginate(6);
            return view('principal.index', compact('produtos'));

    }

    public function pos_cad(){
        if(Auth::check()){
            //$produtos = Produto::paginate(6);
            $produtos = DB::table('produtos')
                        ->join('estoques', 'produtos.id', '=', 'estoques.produto')
                        ->select('produtos.*', 'estoques.quantidade')
                        ->paginate(6);
            return view('principal.index', compact('produtos'));;
        } else{
            return redirect('/');
        }
        
    }

}