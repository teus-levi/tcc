<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venda extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'modoRecebimento', 'parcelas', 'saldoReceber', 'vencimento', 'nomeRecebedor', 'logradouro', 'numero', 'CEP', 'bairro', 'cidade', 'estado', 'statusEntrega', 'cliente'
    ];

    public function getItens(){
        return $this->hasMany(ItensVenda::class, 'venda');
    }

    public function getItensDeleted(){
        return $this->hasMany(ItensVenda::class, 'venda')->withTrashed();
    }

    public function getUser(){
        return $this->belongsTo(User::class, 'cliente');
    }

}
