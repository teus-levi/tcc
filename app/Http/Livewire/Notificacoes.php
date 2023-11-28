<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Notificacao;


class Notificacoes extends Component
{
    public $vendas;
    public $estoque;
    public $noti;
    public $quantidade = 0;

    protected $listeners = ['refreshComponent2' => '$refresh'];
    
    public function mount(){
        $this->atualizar();
    }

    public function render()
    {
        return view('livewire.notificacoes');
    }

    public function atualizar(){
        $this->noti = Notificacao::where('lido', 0)->OrderBy('created_at')->get();
        foreach ($this->noti as $notif) {
            $this->quantidade++;
        }
    }
}
