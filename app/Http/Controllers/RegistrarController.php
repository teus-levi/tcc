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
use App\Models\ItensVenda;
use App\Models\Notificacao;
use App\Http\Livewire\Notificacoes;
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
            //validação de nome
            $nome = Produto::query()->withTrashed()->where('nome', '=', $request->nome)->get();
            if(!isset($nome[0])){
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
            } else{
                $request->session()->flash('erro', "Produto com o nome {$request->nome} já existe, use ou ative o existente!");
                return redirect('registrarProdutos');
            }
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
            $usuarios = User::query()->orderBy('id')->paginate(10);
            
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

    public function reg_compra(Request $request){
        if(Auth::check()){  
            $pagamento = $request->all();

            $endereco = $request->session()->get('compra');
            $carrinho = $request->session()->get('cart');

            $dados = $pagamento + $endereco;
            //dd($dados);

            $venda = new Venda;
            if(!is_null($dados['descricao'])){
                $venda->descricao = $dados['descricao'];
            }

            $venda->modoRecebimento = $dados['flexRadioDefault'];
            
            $venda->nomeRecebedor = $dados['nomeRecebedor'];
            $venda->CEP = $dados['cep'];
            $venda->cidade = $dados['cidade'];
            $venda->estado = $dados['estado'];
            $venda->logradouro = $dados['logradouro'];
            $venda->bairro = $dados['bairro'];
            $venda->numero = $dados['numero'];
            $venda->statusEntrega = "Em preparação.";
            $venda->parcelas = 1;
            //verificar saldo total da compra

            $venda->saldoReceber = 0;

            //Verificar id do cliente e a existência
            $user = Auth::id();
            $cliente = Cliente::where('usuario', $user)->first();
            if(isset($cliente)){
                //dd($cliente);
                $venda->cliente = $cliente->id;
            } else {
                $request->session()->flash('erro', "O usuário não existe. Em caso de erro, contate o administrador.");
                return redirect()->route('confirmarEndereco');
            }

            //Verificar data atual para salvar
            date_default_timezone_set('America/Sao_Paulo');
            $data = date('Y-m-d');
            $venda->vencimento = $data;

            $venda->save();

            //Adicionando produtos do carrinho na venda
            foreach (session('cart') as $id => $item) {
                $produto = Produto::find($item['id']);
                if(!is_null($produto)){
                $produtoQtd = $produto->getEstoques[0]->quantidade;
                    if($produtoQtd >= $item['quantidade']){
                        //Criando registro na tabela ItensVendas
                        $produtoVenda = ['produto' => $produto->id, 'quantidade' => $item['quantidade'], 'valorUnitario' => $produto->precoVendaAtual, 'venda' => $venda->id];
                        $itensVenda = ItensVenda::create($produtoVenda);
                        //Modificando quantidade na tabela do produto, pegando o estoque mais antigo que não seja preenchido o campo de delete
                        $quantidade = $produtoQtd - $item['quantidade'];
                        Estoque::where('id', $produto->getEstoques[0]->id)->update([
                            'quantidade' => $quantidade
                        ]);
                        //Ajustando notificações
                        /*
                        $notif = new Notificacao;
                        $notif->descricao = "Confira no código #{$venda->id}";
                        $notif->venda = $venda->id;
                        $notif->save();
                        */
                        if($quantidade == 0){
                            //o get pode trazer mais de 1 objeto, o first traria valor único
                            //também poderia usar o delete na frente da collection
                            $estoqueVazio = Estoque::where('id', $produto->getEstoques[0]->id)->get();
                            $estoqueVazio[0]->delete();
                            $request->session()->forget('cart');
                        }
                    } else {
                        $request->session()->flash('erro', "O produto {$produto->nome} está com uma quantidade em estoque menor do que informado, fazendo a compra não ser finalizada. Por favor ajuste a quantidade. Quantidade restante: {$produto->getEstoques[0]->quantidade}.");
                        return redirect()->route('listarCarrinho');
                    }
                    
                } else {
                    $request->session()->flash('erro', "O produto informado (id {$item['id']}) está incorreto, verifique novamente e/ou contate o administrador!");
                    return redirect()->route('listarCarrinho');
                }
                

            }


            return view('listar.fecharPedido', compact('venda'));
        } else{
            return redirect('/home');
        }
    }

}