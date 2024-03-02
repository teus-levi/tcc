<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoFarmacia extends Model
{
    use HasFactory;

    protected $fillable = [
        'farmacia_id', 'produto_id', 'descricao', 'precoCompra', 'precoVendaAtual', 'quantidade', 'lote', 'validade'
    ];

    /**
     * 
     * $table->id();
     *       $table->foreignId(Farmacia::Class);
     *       $table->foreignId(Produto::Class);
     *       $table->text('Descricao');
     *       $table->double('precoCompra');
     *       $table->double('precoVendaAtual');
     *       $table->int('quantidade');
     *       $table->string('lote');
     *       $table->string('validade');
     *       $table->softDeletes();
     *       $table->timestamps();
     */
}
