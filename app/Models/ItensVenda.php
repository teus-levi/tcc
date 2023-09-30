<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItensVenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantidade', 'valorUnitario', 'venda_id', 'produtofarmacia_id'
    ];

    /**
     * $table->int('quantidade');
     *       $table->double('valorUnitario');
     *       $table->foreignId(Venda::Class);
     *       $table->foreignId(ProdutoFarmacia::Class);
     */
}
