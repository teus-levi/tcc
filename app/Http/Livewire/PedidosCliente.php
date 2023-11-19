<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Pedido;
use App\Models\ItensVenda;
use App\Models\Produto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidosCliente extends Component
{
    public $pedidos;
    public $itensPedidos;

    public $periodo;
    public $ordenacao;

    public function mount(){
        $id = Auth::id();
        $this->pedidos = DB::table('vendas')
                        ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                        ->where('vendas.cliente', '=', $id)
                        ->whereNull('vendas.deleted_at')
                        ->whereNull('itens_vendas.deleted_at')
                        ->select('vendas.*', 'itens_vendas.id as id_itensVenda','itens_vendas.venda')
                        ->orderBy('vendas.id', 'desc')
                        ->get();
                        
        $this->itensPedidos = DB::table('vendas')
                        ->join('itens_vendas', 'vendas.id', '=', 'itens_vendas.venda')
                        ->join('produtos', 'produtos.id', '=', 'itens_vendas.produto')
                        ->where('vendas.cliente', '=', $id)
                        ->whereNull('vendas.deleted_at')
                        ->whereNull('itens_vendas.deleted_at')
                        ->select('itens_vendas.*', 'produtos.id', 'produtos.nome')
                        ->orderBy('itens_vendas.venda')
                        ->get();
    }

    public function save(){
        dd($this->periodo);
        $this->periodo = $periodo;
        $this->periodo = $ordenacao;


    }
    
    public function render()
    {
        return view('livewire.pedidos-cliente');
    }

}
