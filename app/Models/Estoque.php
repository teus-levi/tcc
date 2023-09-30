<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{
    use HasFactory;

    protected $fillable= ['produto', 'quantidade', 'precoCompra', 'lote', 'validade'];

    public function produto(){
        return $this->hasOne(Estoque::class, 'produto', 'id');
     }
}
