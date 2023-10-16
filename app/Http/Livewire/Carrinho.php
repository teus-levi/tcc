<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Carrinho extends Component
{
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function render()
    {
        return view('livewire.carrinho');
    }
}
