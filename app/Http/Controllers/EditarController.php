<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\User;
use App\Models\Estoque;
use App\Models\Venda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;
use App\Rules\CPF;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
            return redirect()->route('login');
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
                    $request->session()->flash('mensagem', "Produto e estoque desativados com sucesso!");
                    return redirect()->route('listarProdutos');
                } else {
                $produto->delete();
                $request->session()->flash('mensagem', "Produto desativado com sucesso!");
                return redirect()->route('listarProdutos');
                }
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function active_prod(Request $request){
        $produto = Produto::withTrashed()->find($request->id);
            if($produto){
                $estoque = Estoque::withTrashed()->where('produto', $request->id)->get();
                if($estoque){
                    foreach ($estoque as $item) {
                        /*
                        Estoque::where('id', $item->id)
                                ->where('quantidade', '>', 0)
                                ->update([
                                    'deleted_at' => NULL
                                ]);
                        */
                        //apenas estoque com quantidade para ser ativado
                        if($item->quantidade > 0 ){
                            $item->deleted_at = NULL;
                            $item->save();
                        }
                    }
                    $produto->deleted_at = NULL;
                    $produto->save();
                    $request->session()->flash('mensagem', "Produto e estoque(s) com quantidade ativados com sucesso!");
                    return redirect()->route('listarProdutos');
                } else {
                    $produto->deleted_at = NULL;
                    $produto->save();
                    $request->session()->flash('mensagem', "Produto ativado com sucesso!");
                    return redirect()->route('listarProdutos');
                }
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
            return redirect()->route('login');
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
            return redirect()->route('login');
        }
    }

    public function edit_marca(Request $request){
        if(Auth::check()){
        $marca = Marca::find($request->id);
        return view('editar.marcas', compact('marca'));
        } else {
            return redirect()->route('login');
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
            return redirect()->route('login');
        }
    }

    public function delete_marca(Request $request){
        if(Auth::check()){
            $marca = Marca::find($request->id);
            if($marca){
                $marca->delete();
                $request->session()->flash('mensagem', "Marca deletada com sucesso!");
                return redirect()->route('listarMarcas');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function active_marca(Request $request){
        //dd($request->id);
        $marca = Marca::withTrashed()->find($request->id);
            if($marca){
                $marca->deleted_at = NULL;
                $marca->save();
                $request->session()->flash('mensagem', "Marca ativada com sucesso!");
                return redirect()->route('listarMarcas');
            } else {
                return redirect('/home');
            }
    }

    public function edit_categoria(Request $request){
        if(Auth::check()){
        $categoria = Categoria::find($request->id);
        return view('editar.categorias', compact('categoria'));
        } else {
            return redirect()->route('login');
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
            return redirect()->route('login');
        }
    }

    public function delete_categoria(Request $request){
        if(Auth::check()){
            $categoria = Categoria::find($request->id);
            if($categoria){
                $categoria->delete();
                $request->session()->flash('mensagem', "Categoria deletada com sucesso!");
                return redirect()->route('listarCategorias');
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function active_categoria(Request $request){
            $categoria = Categoria::withTrashed()->find($request->id);
            if($categoria){
                $categoria->deleted_at = NULL;
                $categoria->save();
                $request->session()->flash('mensagem', "Categoria ativada com sucesso!");
                return redirect()->route('listarCategorias');
            } else{
                return redirect('/home');
            }
    }

    //confirmação do endereço para salvar na entrega
    public function confirmar_endereco(){
        if(Auth::check()){
            $id = Auth::id();
            $usuario = DB::table('users')
            ->where('users.id', '=', $id)
            ->select('users.name', 'users.id')
            ->get();
            return view('editar.confirmarEndereco', compact('usuario'));
        } else {
            return redirect()->route('login');
        }
    }
    public function edit_endereco(){
        if(Auth::check()){
            $id = Auth::id();
            $endereco = Cliente::where('usuario', $id)->get();
            return view('editar.endereco', compact('endereco'));
        } else {
            return redirect()->route('login');
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

            /*$validator = Validator::make($dadosApi, [
                'nome' => 'required|min:6|max:100',
                'CPF' => ['required', new CPF],
                'telefone' => 'required|numeric|min_digits:10|max_digits:11',
                'dataNascimento' => 'required|after:01/01/1920|before:01/01/2010',
            ]
            );
            //dd($validator->errors()->all());

                if($validator->fails()){
                    return redirect('/endereco')
                    ->withErrors($validator);
                }
*/

            if(!empty($dadosApi['erro'])){
                $request->session()->flash('erro', "O CEP está incorreto, por isso o endereço informado não foi salvo. Tente novamente.");
            }else if($dadosApi['localidade'] != "Umuarama"){
                $request->session()->flash('erro', "No momento atendemos apenas a cidade de Umuarama. Em breve teremos novas localidades.");
            }
            elseif(!empty($dadosApi['logradouro']) && !empty($dadosApi['bairro'])){
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
                } else if(is_null($request->bairro)){
                    $request->session()->flash('erro', "Preencha o campo do bairro!");
                } else {
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
            return redirect()->route('login');
        }
    }
    public function edit_senha(){
        if(Auth::check()){
            return view('editar.senha');
        } else{
            return redirect()->route('login');
        }
    }

    public function store_senha(Request $request){
        if(Auth::check()){
            //validando informações
            //dd($request->all());
            $dados = $request->all();
            $validator = Validator::make($dados, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->mixedCase()->symbols()],
                'password_confirmation' => 'required',
            ]
            );
            //dd($validator->errors()->all());

                if($validator->fails()){
                    return redirect('/senha')
                    ->withErrors($validator);
                }else{

                //update no banco
                $id = Auth::id();
                $senha = Hash::make($request->password);
                User::where('id', $id)->update([
                    'password' => $senha
                ]);
                $request->session()->flash('mensagem', "Senha editada com sucesso!");
                return redirect('/senha');
                }
        }   else {
                return redirect()->route('login');
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
            return redirect()->route('login');
        }
    }

    public function store_perfil(Request $request){
        $id = Auth::id();
        if(Auth::check() && $id == $request->id){
            //formatando informações
            //dd($request->all());
            $dados = $request->all();
            $cpf = array(".", "-");
            $dados['CPF'] = str_replace($cpf, "", $request->CPF);
            $telefone = array("(", ")", "-", " ");
            $dados['telefone'] = str_replace($telefone, "", $request->telefone);


            $validator = Validator::make($dados, [
                'nome' => 'required|min:6|max:100',
                'CPF' => ['required', new CPF],
                'telefone' => 'required|numeric|min_digits:10|max_digits:11',
                'dataNascimento' => 'required|after:01/01/1920|before:01/01/2010',
            ]
            );
            //dd($validator->errors()->all());

                if($validator->fails()){
                    return redirect('/perfil')
                    ->withErrors($validator);
                }

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
            return redirect()->route('login');
        }
    }

    public function edit_venda(Request $request){
        $venda = Venda::withTrashed()->find($request->id);
        //dd($venda);
        return view('editar.venda', compact('venda'));
    }

    public function store_venda(Request $request){

            //formatando informações
            date_default_timezone_set('America/Sao_Paulo');
            $dataAtual = date('Y-m-d');
            //dd($request->all());
            $parcelas = $request->parcelas;
            $vencimento = $request->vencimento;
            $pontuacao = array(".", ",");
            $saldo= str_replace($pontuacao, "", $request->saldo);
            if($parcelas >= 1 && $saldo >= 0 && $vencimento >= $dataAtual){
                //update no banco
                Venda::where('id', $request->id)->update([
                    'parcelas' => $request->parcelas,
                    'saldoReceber' => $saldo,
                    'vencimento' => $request->vencimento,
                    'statusEntrega' => $request->status
                ]);
                $venda = Venda::find($request->id);
                $this->sendMail($venda);

                $request->session()->flash('mensagem', "Informações atualizadas com sucesso!");
                return redirect()->route('editarVenda', [$request->id]);
            } else{
                $request->session()->flash('erro', "Verifique novamente as informações!");
                return redirect()->route('editarVenda', [$request->id]);
            }


    }
    //usuário cancelando o pedido que fez
    public function store_pedido(Request $request){
        $pedido = Venda::find($request->id);
        $cliente = Cliente::first('usuario', Auth::id());
        if($pedido){
            if($pedido->cliente != $cliente->id && $cliente->getUsuario->administrador == 0){
                $request->session()->flash('erro', 'Usuários diferentes, entre na conta correta.');
                return redirect('/home');
            }
            //separando a quantidade dos produtos em estoque
            $produtoEstoque = $pedido->getItens;
            if($pedido->statusEntrega != "Em preparação." && $pedido->statusEntrega != "Aguardando pix."){
                $request->session()->flash('erro', "Não é possível cancelar o pedido pelo sistema, entre em contato com a farmácia.");
                return redirect()->route('listarDetalhesPedido', [$request->id]);
            } else {
                $pedido->statusentrega = "Cancelado.";
                $pedido->descDelete = "Cancelado pelo cliente.";
                $pedido->save();
                $pedido->delete();

                //repondo valores no estoque
                foreach ($produtoEstoque as $item) {
                    //pegar todos os estoques
                    $idEstoque = $item->getProduto->getAllEstoques;
                    //dd($idEstoque);
                    //Pegar o último estoque cadastrado
                    $estoqueId = 0;
                    foreach ($idEstoque as $estoque) {
                        $estoqueId = $estoque->id;
                    }
                    $qtd = Estoque::withTrashed()->where('id', $estoqueId)->get();

                    if(!is_null($qtd[0]->deleted_at)){
                        Estoque::withTrashed()->where('id', $estoqueId)->update([
                            'deleted_at' => NULL
                        ]);

                    }

                    $qtdTotal = $qtd[0]->quantidade + $item->quantidade;
                    Estoque::withTrashed()->where('id', $estoqueId)->update([
                        'quantidade' => $qtdTotal
                    ]);
                }

                $request->session()->flash('mensagem', "Pedido cancelado com sucesso!");
                return redirect()->route('listarDetalhesPedido', [$request->id]);
            }
        } else {
            $request->session()->flash('erro', "Ocorreu um erro, tente novamente!");
            return redirect()->route('listarDetalhesPedido', [$request->id]);
        }
    }

    public function cancelar_venda(Request $request){

            //dd($request->motivo);

        $venda = Venda::find($request->id);
            if(!is_null($venda)){
            //implementar motivo
            $motivo = $request->motivo;

            $venda->descDelete = $motivo;
            $usuario = $venda->getUser;
            $venda->statusEntrega = "Cancelado.";
            $venda->save();

            $venda->delete();

            $this->sendMail($venda);

            $request->session()->flash('mensagem', "Venda cancelada com sucesso!");
            return redirect()->route('listarVendas');
        } else {
            $request->session()->flash('erro', "Algo deu errado, tente novamente!");
            return redirect()->route('listarVendas');
        }
    }

    public function sendMail(Venda $venda){
        $usuario = $venda->getUser;
        $nome = explode(' ', $usuario->name);
        $tempo = now()->addSecond(2);

        if($venda->statusEntrega == "Cancelado."){
            $mail = new RegisterEmail([
                'nome' => $nome[0],
                'mensagem' => "Informamos que seu pedido número {$venda->id} foi cancelado.
                <br>Motivo: $venda->descDelete"
            ]);
            Mail::to($usuario->email)->later($tempo, $mail);

        } else if($venda->statusEntrega == "Em preparação."){
            $mail = new RegisterEmail([
                'nome' => $nome[0],
                'mensagem' => "Seu pedido número {$venda->id} está em preparação, aguarde até ser notificado novamente."
            ]);
            Mail::to($usuario->email)->later($tempo, $mail);
        } else if($venda->statusEntrega == "Aguardando pix."){
            $mail = new RegisterEmail([
                'nome' => $nome[0],
                'mensagem' => "Seu pedido número {$venda->id} será separado para entrega após pagamento mediante comprovação."
            ]);
            Mail::to($usuario->email)->later($tempo, $mail);
        } else if($venda->statusEntrega == "Em transporte."){
            $mail = new RegisterEmail([
                'nome' => $nome[0],
                'mensagem' => "Seu pedido número {$venda->id} está em transporte, aguarde a entrega ser finalizada."
            ]);
            Mail::to($usuario->email)->later($tempo, $mail);
        } else {
            //entregue
            $mail = new RegisterEmail([
                'nome' => $nome[0],
                'mensagem' => "Seu pedido número {$venda->id} foi entregue! Agradecemos a preferência."
            ]);
            Mail::to($usuario->email)->later($tempo, $mail);
        }


        //use o return para visualizar o email antes de ser enviado

        //Mail::to('mateusdias2001@gmail.com')->send($mail);
    }

}
