<?php

namespace App\Http\Controllers;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Models\User;


class Utilidades {

    public function listar_prod(){
        if(Auth::check()){
            //$produtos = Produto::query()->orderBy('id')->get();
            $produtos = Produto::paginate(6);


            return view('principal.index', compact('produtos'));
        } else{
            return redirect('/home');
        }
        
    }
    
}