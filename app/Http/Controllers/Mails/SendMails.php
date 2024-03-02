<?php

namespace App\Http\Controllers\Mails;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterEmail;

class SendMails extends Controller
{
    public function sendMail(){
        $mail = new RegisterEmail([
            'nome' => 'mateus',
            'mensagem' => 'Informamos que seu pedido número 5 saiu para entrega, em breve chegará ao destino.'
        ]);

        //use o return para visualizar o email antes de ser enviado
        return $mail;

        //Mail::to('mateusdias2001@gmail.com')->send($mail);
    }
}
