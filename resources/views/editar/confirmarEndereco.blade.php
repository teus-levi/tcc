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
                    <form>
                        <div class="form-group mb-2">
                            <label for="exampleInputuname">Nome da pessoa</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-user"></i></i></div>
                                <input type="text" class="form-control" id="exampleInputuname" placeholder="Nome e Sobrenome">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="exampleInputEmail1">CEP</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-city"></i></div>
                                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="00000-000">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="exampleInputpwd1">Cidade</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-city"></i></i></div>
                                <input type="password" class="form-control" id="exampleInputpwd1" placeholder="Escolha a cidade">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label for="exampleInputpwd2">Logradouro</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-street-view"></i></i></div>
                                <input type="password" class="form-control" id="exampleInputpwd2" placeholder="Informe o endereço">
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <label for="exampleInputpwd2">Número</label>
                            <div class="input-group">
                                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-house-user"></i></div>
                                <input type="password" class="form-control" id="exampleInputpwd2" placeholder="Informe o número da casa">
                            </div>
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