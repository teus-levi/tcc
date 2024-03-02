<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produto;
use App\Models\Marca;

class BotaoCarrinhoProduto extends Component
{
    public $produto;
    public $carrinho;


    public function addProdutoCarrinho($id){
        $produto = Produto::find($id);
        $marca = Marca::find($produto->marca);
        $cart = session()->get('cart', []);
        if(isset($cart[$id]) && ($cart[$id]['quantidade'] + 1) <= 10){
            $cart[$id]['quantidade']++;
        } else {
            $cart[$id] = [
                "id" => $produto->id,
                "nome" => $produto->nome,
                "marca" => $marca->nome,
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
