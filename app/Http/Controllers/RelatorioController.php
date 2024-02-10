<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function filtro_estoque(){
        return view('relatorios.filtroEstoque');
    }
}
