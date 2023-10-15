<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListarMarcas extends Component
{
    public $marca;
    public $searchTerm;

    public function render()
    {
        //Pegar as marcas
        $marcas = Marca::where('name', 'like', '%' .$this->searchTerm. '%')->get();
        return view('livewire.listar-marcas');
    }

    public function mount($marca, $marcas){
        $this->marca = $marca;

    }
}
