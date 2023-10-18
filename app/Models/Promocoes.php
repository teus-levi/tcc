<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocoes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'dataInicial', 'dataFinal', 'valorPromocao', 'produtoFarmacia_id'
    ];

    /**
     * $table->id();
        *    $table->date('dataInicial');
        *    $table->date('dataFinal');
        *    $table->double('valorPromocao');
        *    $table->foreignId(ProdutoFarmacia::Class);
        *    $table->softDeletes();
        *    $table->timestamps();
     */
}
