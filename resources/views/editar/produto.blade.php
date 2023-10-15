@extends('layout')

@section('titulo')
    BabyOn - Ediçao de Produto
@endsection
@push('dropify_style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">
@endpush

@section('conteudo')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h2 style="margin-left: 0%;" class="text-center">Produto</h2>
                    <p class="text-muted text-center mb-5">A edição do produto não afeta o estoque</p>
                    <form class="form" action="/storeEditProduto/{{$produto[0]->id}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <!-- Tentar modificar para não alterar no inspecionar elemento 
                        <div class="form-group row">
                            <label for="id" class="col-2 mb-4 col-form-label">ID</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$produto[0]->id}}" id="id" name="id" readonly="redonly">
                            </div>
                        </div>-->
                        <div class="form-group row">
                            <label for="nomeProduto" class="col-2 mb-4 col-form-label">Nome</label>
                            <div class="col-10">
                                <input class="form-control" type="text" value="{{$produto[0]->nome}}" id="nomeProduto" name="nome">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="precoVenda" class="col-2 mb-4 col-form-label">Preço de Venda</label>
                            <div class="col-10">
                                <input class="form-control" type="number" value="{{$produto[0]->precoVendaAtual}}" id="precoVenda" name="precoVenda">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="single-select-field" class="col-2 mb-4 col-form-label">Categoria</label>
                            <div class="col-10">
                                <div class="form-floating mx-auto d-block mb-4">
                                    <!-- Usando select2 para poder ter a opção de pesquisa-->
                                    <select class="form-select" id="single-select-field" name="categoria">
                                        <option value="{{$produto[0]->id_categoria}}" selected> {{$produto[0]->n_categoria}}</option>
                                          <?php
                                
                                                  foreach ($categorias as $categoria): ?>
                                                  <option value="{{ $categoria->id }}"><?= $categoria->id, " - ", $categoria->nome ?></option>
                                                  <?php endforeach;
                                          ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-date-input" class="col-2 mb-4 col-form-label">Marca</label>
                            <div class="col-10">
                                <div class="form-floating mx-auto d-block mb-4">

                                    <!-- Usando select2 para poder ter a opção de pesquisa-->
                                    <select class="form-select" id="single-select-field" name="marca">
                                        <option value="{{$produto[0]->id_marca}}" selected> {{$produto[0]->n_marca}}</option>
                                          <?php
                                
                                                  foreach ($marcas as $marca): ?>
                                                  <option value="{{ $marca->id }}"><?= $marca->id, " - ", $marca->nome ?></option>
                                                  <?php endforeach;
                                          ?>
                                    </select>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="descricao" class="col-2 mb-4 col-form-label">Descrição</label>
                            <div class="col-10">
                                <textarea class="form-control mb-4" name="descricao" id="descricao" placeholder="Digite a descrição do produto" maxlength="100">{{$produto[0]->descricao}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 ol-md-6 col-xs-12">
                                <div class="white-box mt-4 mb-4">
                                    <h4 class="box-title">Imagem</h3>
                                    <label for="input-file-now-custom-1">Uma única imagem pode ser adicionada (450x400)</label>
                                    <input type="file" id="input-file-now-custom-1" class="dropify" data-default-file="../storage/{{$produto[0]->imagem}}" name="imagem"/>
                                </div>
                            </div>
                        </div>
                        <a href="/listarProdutos" class="btn btn-secondary mt-3">
                            Voltar
                        </a>
                        <button type="submit" value="{{$produto[0]->id}}" name="id" class="btn btn-success mt-3">Salvar</button>             
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
