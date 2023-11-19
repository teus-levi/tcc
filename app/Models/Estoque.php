<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estoque extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable= ['produto', 'quantidade', 'precoCompra', 'lote', 'validade'];

    public function produto(){
        return $this->hasOne(Produto::class, 'id', 'produto');
     }
}
