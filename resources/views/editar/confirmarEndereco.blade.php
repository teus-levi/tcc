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
                    <form method="get" class="needs-validation" novalidate>
                        <div class="form-group mb-2">
                            <label for="exampleInputuname">Nome da pessoa</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-user"></i></i></div>
                                <input type="text" class="form-control" id="exampleInputuname" placeholder="Nome e Sobrenome">
                            </div>
                        </div>
                        @livewire('confirmar-endereco')
                        <div class="form-group mb-1">
                            <label for="exampleInputpwd2">Número</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-house-user"></i></div>
                                <input type="number" class="form-control" id="exampleInputpwd2" placeholder="Informe o número da casa">
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-text">
                              <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div>
                            <input type="text" class="form-control" value="Sem número no domicílio" aria-label="Text input with checkbox" readonly>
                          </div>
                        <a href="/carrinho" class="btn btn-secondary">Voltar</a>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection