<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItensVenda extends Model
{
    use HasFactory;
    use SoftDeletes;

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
