<?php

namespace App\Http\Livewire;

use App\Models\Produto;
use Livewire\Component;

class ListarCarrinho extends Component
{
    public $total;

    public function increment($id){
        $produto = Produto::find($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantidade']++;
            $this->total += $produto->precoVendaAtual;
            
        } else {
            return redirect()->rout('/home');
        }
        session()->put('cart', $cart);
        $this->emitTo('carrinho', 'refreshComponent');
    }

    public function decrement($id){
        $produto = Produto::find($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $cart[$id]['quantidade']--;
            $this->total -= $produto->precoVendaAtual;
        } else {
            return redirect()->rout('/home');
        }
        session()->put('cart', $cart);
        $this->emitTo('carrinho', 'refreshComponent');
    }

    public function remove($id){
        $produto = Produto::find($id);
        $cart = session()->get('cart', []);
        if(isset($cart[$id])){
            $this->total -= ($cart[$id]['quantidade'] * $cart[$id]['preco']);
            unset($cart[$id]);
            session()->forget('cart');
            session()->put('cart', $cart);
        } else {
            return redirect()->rout('/home');
        }
        $this->emitTo('carrinho', 'refreshComponent');
    }

    public function render()
    {
        if(!isset($this->total)){
            foreach (session('cart') as $id => $item) {
                $this->total += ($item['quantidade'] * $item['preco']);
            }
        }
        
        return view('livewire.listar-carrinho');
    }
}
