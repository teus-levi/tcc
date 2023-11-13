<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = [
        'modoRecebimento', 'parcelas', 'saldoReceber', 'vencimento', 'nomeRecebedor', 'logradouro', 'numero', 'CEP', 'bairro', 'cidade', 'estado', 'statusEntrega', 'cliente'
    ];
}
