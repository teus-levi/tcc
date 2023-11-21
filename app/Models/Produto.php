<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable= [
        'nome', 'imagem', 'marca', 'categoria', 'administrador', 'descricao', 'precoVendaAtual'
    ];

    public function getEstoques(){
        return $this->hasMany(Estoque::class, 'produto');
    }

    public function getMarca(){
        return $this->belongsTo(Marca::class, 'marca', 'id');
    }

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
