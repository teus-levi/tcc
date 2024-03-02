<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Marca extends Model
{
    use HasFactory;
    use SoftDeletes;

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
