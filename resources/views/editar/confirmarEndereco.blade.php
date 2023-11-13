@extends('layout')

@section('titulo')
    BabyOn - Confirmação de Endereço
@endsection


@section('conteudo')
<div class="container">
<div class="row d-flex justify-content-center mt-3 ">
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title">Endereço de entrega</h3>
            <p class="text-muted m-b-30 font-13"> Verifique antes de concluir a compra</p>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form method="GET" action="/formaPagamento">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="exampleInputuname">Nome da pessoa</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-user"></i></i></div>
                                <input type="text" value="{{$usuario[0]->name}}" name="nomeRecebedor" class="form-control" id="exampleInputuname" placeholder="Nome e Sobrenome">
                            </div>
                        </div>
                        
                        @livewire('confirmar-endereco', ['usuario_id' => $usuario[0]->id])

                        
                        <a href="/carrinho" class="btn btn-secondary mt-3">Voltar</a>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10 mt-3">Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection