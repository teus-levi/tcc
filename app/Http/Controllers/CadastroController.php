<?php
namespace App\Http\Controllers;
use Illuminate\Http\Controllers\Utilidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Farmacia;
use App\Models\User;



class CadastroController extends Controller
{
    public function create(Request $request){
        $mensagem = $request->session()->get('mensagem');

        return view('cadastro.index', compact('mensagem'));
    }

    public function user(Request $request){

        //verifica nulo
        $dados = $request->all();
        foreach($dados as $dado){
            if(empty($dado)){
                $request->session()->flash('mensagem', "Existem campos vazios!");
                $dados = null;
                return redirect('/cadastrar');
            }
        }


        if($request->email_cadastro != $request->email_cadastro_confirmar){
            $request->session()->flash('mensagem', "Emails diferentes!");
            $dados = null;
            return redirect('/cadastrar');
        } else if($request->senha_cadastro != $request->senha_cadastro_confirmar){
            $request->session()->flash('mensagem', "Senhas diferentes");
            $dados = null;
            return redirect('/cadastrar');
        } else {
            $request->session()->put('dados', $dados);
            //dd($request);

            return view('cadastro.cadastrar2');
        }
    }
    
    public static function verificarNulo(String $caminho, Request $request){
        //$inf = $request->session()->get('dados');

        $dados = $request->all();
        unset($dados['_token']);
        //dd($dados);

        $verificar = $dados;
        //dd($verificar);
        foreach($verificar as $dado){
            if(empty($dado)){
                $request->session()->flash('mensagem', "Existem campos vazios!");
                $dados = null;
                return redirect($caminho);
            }
        }
        //dd($dados);
        return $dados;
    }

    
    //apenas clientes
    public function store(Request $request){
        $inf = $request->session()->get('dados');

        $dados = $request->all();
        foreach($dados as $dado){
            if(empty($dado)){
                $request->session()->flash('mensagem', "Existem campos vazios!");
                $dados = null;
                return redirect('/cadastrar2');
            }
        }
        $inf += $dados;
        //remover token
        array_shift($inf);
        //remove duplicações de confirmação e tipo de conta
        

        unset($inf['email_cadastro_confirmar']);
        unset($inf['senha_cadastro_confirmar']);
        //unset($inf['tipoConta']);


        //dd($inf);

        $data = ["name" => $inf['nomeCompleto'], 
                "email" => $inf['email_cadastro'], 
                "password" => $inf['senha_cadastro'],
                "administrador" => 0];

        //dd($data);

        //$data = $request->except('_token');

        /*$status = ['status' => 'A'];
        $inf += $status;
        */

        //criptografia de senha
        $data['password'] = Hash::make($data['password']);

        //cadastrar no banco
        $user = User::create($data);

        //formatando informações
        $inf['cpf'] = str_replace(".", "", $inf['cpf']);
        $inf['dataNascimento'] = str_replace("/", "-", $inf['dataNascimento']);
        $telefone = array("(", ")", "-");
        $inf['telefone'] = str_replace($telefone, "", $inf['telefone']);

        $cliente = new Cliente;
        $cliente->CPF = $inf['cpf'];
        $cliente->dataNascimento = $inf['dataNascimento'];
        $cliente->telefone = $inf['telefone'];
        $cliente->usuario = $user->id;

        $cliente->save();




        //fazer login
        Auth::login($user);
        $request->session()->flash('mensagem', "Cadastrado com sucesso!");

        return redirect()->route('login');
        //return back()->with('message', 'Cadastrado');

    }

    //defasado
    public function store2(Request $request) {
        $inf = $request->session()->get('dados');

        $dados = $request->all();
        foreach($dados as $dado){
            if(empty($dado)){
                $request->session()->flash('mensagem', "Existem campos vazios!");
                $dados = null;
                return redirect('/cadastrar3');
            }
        }

        $inf += $dados;
        /*
        $status = ['status' => 'A'];
        $inf += $status;
        */
        unset($inf['_token']);

        $request->session()->remove('dados');

        //dd($inf);

        //Cadastrar

        //$cliente = Cliente::create($inf);
        
        $cliente = new Cliente();
        $cliente->email = $inf['email_cadastro'];
        $cliente->senha = $inf['senha_cadastro'];
        $cliente->nomeCompleto = $inf['nomeCompleto'];
        $cliente->CPF = $inf['cpf'];
        $cliente->dataNascimento = $inf['dataNascimento'];
        $cliente->telefone = $inf['telefone'];
        $cliente->logradouro = $inf['endereco'];
        $cliente->numero = $inf['numero'];
        $cliente->CEP = $inf['cep'];
        $cliente->bairro = $inf['bairro'];
        $cliente->cidade = $inf['cidade'];
        $cliente->estado = $inf['estado'];
        $cliente->status = $inf['status'];
        $cliente->save();

        return redirect('/');
    }

}