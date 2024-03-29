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
        'listaEstoque', 'produto', 'quantidade', 'valorUnitario', 'venda'
    ];

    public function getProduto(){
        return $this->belongsTo(Produto::class, 'produto', 'id');
    }

    public function getProdutoDeleted(){
        return $this->belongsTo(Produto::class, 'produto', 'id')->withTrashed();
    }

    /**
     * $table->int('quantidade');
     *       $table->double('valorUnitario');
     *       $table->foreignId(Venda::Class);
     *       $table->foreignId(ProdutoFarmacia::Class);
     */
}
