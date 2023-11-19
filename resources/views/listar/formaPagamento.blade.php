@extends('layout')

@section('titulo')
    BabyOn - Confirmação de Pagamento
@endsection


@section('conteudo')
<div class="container">
<div class="row d-flex justify-content-center mt-3 ">
    <div class="col-md-6">
        <div class="white-box">
            <h3 class="box-title">Forma de pagamento</h3>
            <p class="text-muted m-b-30 font-13">Escolha a melhor forma para efetuar o pagamento.</p>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form method="post" action="/registrarCompra">
                        @csrf
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="Cartão" id="flexRadioDefault1" checked>
                            <label class="form-check-label" for="flexRadioDefault1">
                              Cartão de débito/crédito (bandeiras mastercard, visa, etc..).
                            </label>
                          </div>
                          <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="Pix" id="flexRadioDefault2" >
                            <label class="form-check-label" for="flexRadioDefault2">
                              Pagamento no pix.
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" value="Dinheiro" id="flexRadioDefault3">
                            <label class="form-check-label" for="flexRadioDefault3">
                              Pagamento em dinheiro.
                            </label>
                          </div>
                          <hr class="mt-4">
                          <div class="form-group">
                            <label for="descricao" class="mb-1 mt-2 col-form-label">Informações adicionais</label>
                            <div class="col-10">
                                <textarea class="form-control mb-4" name="descricao" id="descricao" placeholder="Informe caso precise de troco ou até mesmo sobre como localizar a residência." maxlength="100"></textarea>
                            </div>
                        </div>
                        
                        <a href="/carrinho" class="btn btn-secondary mt-4">Cancelar</a>
                        <button type="submit" class="btn btn-success waves-effect waves-light m-r-10 mt-4">Finalizar compra</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection