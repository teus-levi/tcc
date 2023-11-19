@extends('layout')

@section('titulo')
    BabyOn - Lista de Marcas
@endsection


@section('conteudo')

<main class="flex-fill">
    <div class="container text-center">
        <h1 class="mt-3">Finalizado!</h1>
        <hr>
        <h3>Anote o número de seu pedido:</h3>
        <div class="text-danger h2"><b>{{$venda->id}}</b></div>
        @if ($venda->modoRecebimento == "Pix")
            <br>
            <p>
                Você escolheu o pagamento por Pix, então para que a entrega seja efetuada, deverá realizar o pagamento com antecedência usando a chave (XX) XXXX-XXXX. 
                <br>O Comprovante deverá ser enviado ao WhatsApp da farmácia no mesmo número.
            </p>
            <p>Após a confirmação do pagamento, em até 2 horas, seu pedido será entregue. Quaisquer dúvidas sobre este pedido, entre em contato conosco informando o número da compra.</p>
            <br>
        @else
            <p>Em até 2 horas, seu pedido será entregue. Quaisquer dúvidas sobre este pedido, entre em contato conosco informando o número da compra.</p>
        @endif
            <p>
                Você poderá acompanhar o status do pedido clicando <a href="/pedidos">aqui.</a>
            </p>
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