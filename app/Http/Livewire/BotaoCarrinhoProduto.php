<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produto;

class BotaoCarrinhoProduto extends Component
{
    public $produto;
    public $carrinho;


    public function addProdutoCarrinho($id){
        $produto = Produto::find($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantidade']++;
        } else {
            $cart[$id] = [
                "nome" => $produto->nome,
                "quantidade" => 1,
                "preco" => $produto->precoVendaAtual,
                "imagem" => $produto->imagem
            ];
        }
        session()->put('cart', $cart);
        $this->emitTo('carrinho', 'refreshComponent');
    }

   
    public function render()
    {
        return view('livewire.botao-carrinho-produto');
    }
}
