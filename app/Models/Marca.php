<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'administrador'
    ];


    /**
     * $table->id()
      *      $table->string('nome');
      *      $table->foreignId(Administrador::Class);
       *     $table->softDeletes();
       *     $table->timestamps();
     */
}
