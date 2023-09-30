<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmacia extends Model
{
    use HasFactory;

    protected $fillable = [
        'CNPJ', 'nomeResponsavel', 'telefoneFarmacia', 'telefonePessoal',
        'logradouro', 'numero', 'CEP', 'bairro', 'cidade', 'estado',
        'user_id'
    ];

    //public $timestamps = false;

    protected $table = 'farmacias';
}
