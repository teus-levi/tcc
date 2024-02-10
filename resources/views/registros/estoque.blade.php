@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Estoque
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Estoque</h2>



    <div class="container">
        <form action="/salvarEstoque/{{$produto->id}}" method="post">
            @csrf
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="nome">Nome do produto: </label>
                <div class="col d-flex align-items-center">
                    {{$produto->nome}}
                </div>
            </div>
            <div class="row mb-2 ">
                <label class="col-sm-2 col-form-label" for="quantidade">Quantidade</label>
                <div class="col-sm-2">
                <input type="number" class="form-control" name="quantidade" id="quantidade">
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="precoCompra">Preço de compra</label>
                <div class="col-sm-2">
                <input type="text" class="form-control precoCompra" name="precoCompra" id="precoCompra">
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="lote">Número do lote</label>
                <div class="col-sm-2">
                <input type="number" class="form-control" name="lote" id="lote">
                </div>
            </div>
            <div class="row mb-2">
                <label class="col-sm-2 col-form-label" for="validade">Validade do lote</label>
                <div class="col-sm-3">
                <input type="month" class="form-control" name="validade" id="validade">
                </div>
            </div>
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
@endsection
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $('.precoCompra').mask("#.##0,00", {reverse: true});
  </script>
@endpush
