<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory;
    use SoftDeletes;
    /*protected $fillable =[
        'CPF', 'nomeCompleto', 'dataNascimento', 'email', 'senha', 'telefone', 'logradouro',
        'numero', 'CEP', 'bairro', 'cidade', 'estado', 'status'
    ];*/
    protected $fillable =[
        'CPF', 'dataNascimento', 'telefone', 'usuario'
    ];

    //public $timestamps = false;

    protected $table = 'clientes';

    public function getUsuario(){
        return $this->hasOne(User::class, 'id', 'usuario');
    }
}
