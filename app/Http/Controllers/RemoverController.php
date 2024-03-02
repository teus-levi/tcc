<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RemoverController extends Controller
{
    public function destroy_administradores(Request $request){
        if(Auth::check()){
            User::where('id', $request->id)->update([
                'administrador' => 0
            ]);
            $request->session()->flash('mensagem', "Administrador removido com sucesso!");
            return redirect('registrarAdministradores');

        } else{
            return redirect('registrarAdministradores');
        }
    }
}
