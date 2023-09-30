<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $fillable= [
        'nome', 'imagem', 'marca', 'categoria', 'administrador', 'descricao', 'precoVendaAtual'
    ];

    /**
     * 
     * $table->id();
     *       $table->string('nome');
     *      $table->binary('imagem');
     *       $table->foreignId(Marca::Class);
     *       $table->foreignId(Categoria::Class);
     *       $table->softDeletes();
     *       $table->timestamps();
     */

     
}
