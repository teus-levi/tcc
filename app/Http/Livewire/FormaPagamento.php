<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
use Illuminate\Support\Facades\Auth;

class FormaPagamento extends Component
{
    public $flexRadioDefault;
    public $descricao;

    public function registrarCompra(Request $request){
        if(Auth::check()){  
            //$pagamento = $request->all();
            $endereco = $request->session()->get('compra');
            $carrinho = $request->session()->get('cart');

            $dados = /*$pagamento + */ $endereco;
            //dd($dados);

            $venda = new Venda;
            if(!is_null($this->descricao)){
                $venda->descricao = $this->descricao;
            }

            $venda->modoRecebimento = $this->flexRadioDefault;
            
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
                        $notif = new Notificacao;
                        $notif->descricao = "Confira no código #{$venda->id}";
                        $notif->venda = $venda->id;
                        $notif->save();
                        $this->emitTo('notificacoes', 'refreshComponent2');
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


            //return view('listar.fecharPedido', compact('venda'));
            return redirect()->route('fecharPedido', [$venda->id]);
        } else{
            return redirect('/home');
        }
    }
    public function render()
    {
        return view('livewire.forma-pagamento');
    }
}
