<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Notificacao extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable= [
        'descricao'
    ];

    public function getEstoque(){
        return $this->belongsTo(Estoque::class, 'estoque', 'id');
    }

    public function getVenda(){
        return $this->belongsTo(Venda::class, 'venda', 'id');
    }

    protected $table = 'notificacao';
}
