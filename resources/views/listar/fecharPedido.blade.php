@extends('layout')

@section('titulo')
    BabyOn - Lista de Marcas
@endsection


@section('conteudo')

<main class="flex-fill">
    <div class="container text-center">
        <h1>Obrigado!</h1>
        <hr>
        <h3>Anote o número de seu pedido:</h3>
        <div class="text-danger"><b>004571</b></div>
        <p>Em até 2 horas, seu pedido será entregue. Quaisquer dúvidas sobre este pedido, entre em contato conosco informando o número do pedido.</p>
        <p>
            Atenciosamente,<br>
            BabyOn
        </p>
        <p>
            <a href="/home" class="btn btn-primary btn-lg">Voltar à Página Principal</a>
        </p>
    </div>
</main>
@endsection