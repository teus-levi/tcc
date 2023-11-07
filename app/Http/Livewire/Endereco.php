<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Endereco extends Component
{
    public $logradouro;
    public $bairro;
    public $cidade;
    public $estado;
    public $cep;
    public $cidadeEstado;
    public $numero;
    public $endereco;

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
    public function mount(){
        if(!is_null($this->endereco)){
        $this->logradouro = $this->endereco->logradouro;
        $this->bairro = $this->endereco->bairro;
        $this->cidade = $this->endereco->cidade;
        $this->estado = $this->endereco->estado;
        $this->numero = $this->endereco->numero;
        $this->cep = $this->endereco->CEP;
        $this->cidadeEstado = $this->endereco->cidade . ' - ' . $this->endereco->estado;
        }
    }
    public function render()
    {
        return view('livewire.endereco');
    }
}
