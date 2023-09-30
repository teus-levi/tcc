<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    /*protected $fillable =[
        'CPF', 'nomeCompleto', 'dataNascimento', 'email', 'senha', 'telefone', 'logradouro',
        'numero', 'CEP', 'bairro', 'cidade', 'estado', 'status'
    ];*/
    protected $fillable =[
        'CPF', 'dataNascimento', 'telefone', 'usuario'
    ];

    //public $timestamps = false;

    protected $table = 'clientes';
}
