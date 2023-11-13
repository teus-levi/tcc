<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Cliente;

class ConfirmarEndereco extends Component
{
    public $logradouro;
    public $bairro;
    public $cidade;
    public $estado;
    public $cep;
    public $cidadeEstado;
    public $numero;
    public $usuario;
    public $usuario_id;

    public function buscarCep($cep){
        //remove caracteres não numéricos
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $resposta = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
        $dadosApi = $resposta->json();
        if(!isset($dadosApi['erro']) && isset($dadosApi['localidade'])){
            $this->logradouro = $dadosApi['logradouro'];
            $this->bairro = $dadosApi['bairro'];
            $this->cidade = $dadosApi['localidade'];
            $this->estado = $dadosApi['uf'];
            $this->cidadeEstado = $dadosApi['localidade'] . ' - ' . $dadosApi['uf'];
            $this->numero = null;
        } else {
            

            $this->dispatchBrowserEvent('swal:modal');
            $this->logradouro = null;
            $this->bairro = null;
            $this->cidade = null;
            $this->estado = null;
            $this->cidadeEstado = null;
            $this->numero = null;
        }
    }
    public function mount(){
        $this->usuario = DB::table('users')
            ->join('clientes', 'users.id', '=', 'clientes.usuario')
            ->where('users.id', '=', $this->usuario_id)
            ->select('clientes.*')
            ->get();

        $this->logradouro = $this->usuario[0]->logradouro;
        $this->bairro = $this->usuario[0]->bairro;
        $this->cidade = $this->usuario[0]->cidade;
        $this->estado = $this->usuario[0]->estado;
        $this->numero = $this->usuario[0]->numero;
        $this->cep = $this->usuario[0]->CEP;
        $this->cidadeEstado = $this->usuario[0]->cidade . ' - ' . $this->usuario[0]->estado;

    }

    public function render()
    {
        return view('livewire.confirmar-endereco');
    }
}
