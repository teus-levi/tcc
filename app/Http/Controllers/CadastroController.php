<?php
namespace App\Http\Controllers;
use Illuminate\Http\Controllers\Utilidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Farmacia;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Rules\CPF;



class CadastroController extends Controller
{
    public function create(Request $request){
        $mensagem = $request->session()->get('mensagem');

        return view('cadastro.index', compact('mensagem'));
    }

    public function user(Request $request){

        //verifica nulo
        //$dados = $request->all();
        //foreach($dados as $dado){
         //   if(empty($dado)){
        //        $request->session()->flash('mensagem', "Existem campos vazios!");
        //        $dados = null;
        //        return redirect('/cadastrar');
        //}
        //}
        $dados = '';
        if(is_null($request->email)){
            $rec = $request->session()->get('dados');
            if(is_null($rec)){
                return redirect('/cadastrar');
            } else{
                $dados = $rec;
            }
        } else {
            $dados = $request->all();
        }

        $validator = Validator::make($dados, [
            'email' => 'required|email|confirmed|unique:users,email',
            'email_confirmation' => 'required|email',
            'password' => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()->symbols()],
            'password_confirmation' => 'required',
        ],
        [
            'email_cadastro.required' => 'O campo de email é obrigatório',
            'email.unique' => 'O email informado já está cadastrado, utilize outro.',
            'email_cadastro_confirmar.required' => 'O campo de  confirmar email é obrigatório',
            'email_cadastro_confirmar.email' => 'No campo confirmar email é necessário ter um email válido.',
            'senha_cadastro.required' => 'No campo confirmar email é necessário ter um email válido.',
            'senha_cadastro.min' => 'A senha deve ter ao menos :min caracteres.',
            'senha_cadastro.letters' => 'A senha deve ter ao menos uma letra.',
            'senha_cadastro.numbers' => 'A senha deve ter ao menos um número.',
            'senha_cadastro_confirmar.required' => 'O campo de confirmar senha é obrigatório.',
        ]
        );
        //dd($validator->errors()->all());

            if($validator->fails()){
                return redirect('/cadastrar')
                ->withErrors($validator);
            }else{
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
        if(is_null($inf['email']) || is_null($inf['password'])){
            return redirect('/cadastrar');
        }
        $dados = $request->all();
        //dd($dados);
        //formatando telefone
        $telefone2 = array("(", ")", "-", " ");
        $dados['telefone'] = str_replace($telefone2, "", $dados['telefone']);
        $dados['cpf'] = str_replace(".", "", $dados['cpf']);
        $dados['dataNascimento'] = str_replace("/", "-", $dados['dataNascimento']);
        //dd($dados);

        date_default_timezone_set('America/Sao_Paulo');
        $dataAtual = date('Y-m-d');
        $ano = explode('-', $dataAtual);
        $antes = $ano[2] . '/' . $ano[1] . '/' . ($ano[0] - 14);
        $depois = $ano[2] . '/' . $ano[1] . '/' . ($ano[0] - 110);

        $validator = Validator::make($dados, [
            'nomeCompleto' => 'required|min:6|max:100',
            'telefone' => 'required|min_digits:10|max_digits:11|numeric',
            'cpf' => ['required', new CPF],
            'dataNascimento' => 'required|after:01/01/1920|before:01/01/2010',
        ]);

        if($validator->fails()){
            return redirect('/cadastrar2')
            ->withErrors($validator);
        }


        $inf += $dados;
        //remover token
        array_shift($inf);
        //remove duplicações de confirmação e tipo de conta


        unset($inf['email_confirmation']);
        unset($inf['password_confirmation']);
        //unset($inf['tipoConta']);


        //dd($inf);

        $data = ["name" => $inf['nomeCompleto'],
                "email" => $inf['email'],
                "password" => $inf['password'],
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

        $cliente = new Cliente;
        $cliente->CPF = $inf['cpf'];
        $cliente->dataNascimento = $inf['dataNascimento'];
        $cliente->telefone = $inf['telefone'];
        $cliente->usuario = $user->id;

        $cliente->save();


        //fazer login
        Auth::login($user);
        $request->session()->flash('mensagem', "Cadastrado com sucesso!");

        return redirect('/home');
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
