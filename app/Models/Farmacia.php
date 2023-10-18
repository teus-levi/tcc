<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Farmacia extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'CNPJ', 'nomeResponsavel', 'telefoneFarmacia', 'telefonePessoal',
        'logradouro', 'numero', 'CEP', 'bairro', 'cidade', 'estado',
        'user_id'
    ];

    //public $timestamps = false;

    protected $table = 'farmacias';
}
