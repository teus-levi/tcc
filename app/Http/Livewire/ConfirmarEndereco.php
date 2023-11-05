<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ConfirmarEndereco extends Component
{
    public $logradouro;
    public $bairro;
    public $cidade;
    public $estado;
    public $cep;
    public $cidadeEstado;

    public function buscarCep($cep){
        //remove caracteres não numéricos
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $resposta = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
        $dadosApi = $resposta->json();
        if(!empty($dadosApi['erro'])){
            $this->dispatchBrowserEvent('swal:modal');
            $this->logradouro = null;
            $this->bairro = null;
            $this->cidade = null;
            $this->estado = null;
            $this->cidadeEstado = null;
        } else {
            $this->logradouro = $dadosApi['logradouro'];
            $this->bairro = $dadosApi['bairro'];
            $this->cidade = $dadosApi['localidade'];
            $this->estado = $dadosApi['uf'];
            $this->cidadeEstado = $dadosApi['localidade'] . ' - ' . $dadosApi['uf'];

        }
    }
    public function render()
    {
        return view('livewire.confirmar-endereco');
    }
}
