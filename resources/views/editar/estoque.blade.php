@extends('layout')

@section('titulo')
    BabyOn - Edição de Estoque
@endsection

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h2 style="margin-left: 0%;" class="text-center">Estoque</h2>
                    <p class="text-muted text-center mb-5">Ao editar a quantidade, não confirme novos pedidos!</p>
                    <form class="form" action="/storeEditEstoque/{{$estoque->id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Tentar modificar para não alterar no inspecionar elemento -->
                        <div class="form-group row">
                            <label for="nomeProduto" class="col-2 mb-4 col-form-label">Nome do produto</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$estoque->n_produto}}" id="nomeProduto" name="nome">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="quantidade" class="col-2 mb-4 col-form-label">Quantidade</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="{{$estoque->quantidade}}" id="quantidade" name="quantidade">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="precoCompra" class="col-2 mb-4 col-form-label">Preço</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="{{$estoque->precoCompra}}" id="precoCompra" name="precoCompra">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lote" class="col-2 mb-4 col-form-label">Lote</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="{{$estoque->lote}}" id="lote" name="lote">
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-2 col-form-label" for="validade">Validade do lote</label>
                                <div class="col-sm-3">
                                <input type="month" class="form-control" value="{{$estoque->validade}}" name="validade" id="validade">
                                </div>
                        </div>

                        <a href="/listarEstoque/{{$estoque->produto}}" class="btn btn-secondary mt-3">
                            Voltar
                        </a>
                        <button type="submit" value="{{$estoque->id}}" name="id" class="btn btn-success mt-3">Salvar</button>             
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('dropify_script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    <script>
    $('.dropify').dropify();
    </script>
@endpush
