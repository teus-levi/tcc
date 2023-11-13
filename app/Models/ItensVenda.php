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
        'produto', 'quantidade', 'valorUnitario', 'venda'
    ];

    /**
     * $table->int('quantidade');
     *       $table->double('valorUnitario');
     *       $table->foreignId(Venda::Class);
     *       $table->foreignId(ProdutoFarmacia::Class);
     */
}
