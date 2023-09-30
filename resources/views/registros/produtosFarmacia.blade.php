@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Produtos
@endsection


@section('conteudo')
    <form action="/registrarProdutos" method="post" enctype="multipart/form-data">
        @csrf
        <h2>Produto</h2>
        <div class="text-center mt-3">
            <label for="nome">Nome do produto</label>
            <input type="text" class="form-group" name="nome" id="nome">
        </div>

        <div class="text-center mt-3">
        <label for="imagem">Imagem do produto</label>
        <input type="file" name="imagem" id="imagem">
        </div>
        <div class="form-floating w-25 mx-auto d-block mt-3">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" name="marca">
              <option value="" selected>Abra o menu</option>
                <?php

                        foreach ($marcas as $marca): ?>
                        <option value="{{ $marca->id }}"><?= $marca->id, " - ", $marca->nome ?></option>
                        <?php endforeach;
                ?>
            </select>
            <label for="floatingSelect">Marcas de produtos</label>
          </div>
          <div class="form-floating w-25 mx-auto d-block mt-3">
            <select class="form-select" id="floatingSelect2" aria-label="Floating label select example" name="categoria">
              <option value="" selected>Abra o menu</option>
                <?php

                        foreach ($categorias as $categoria): ?>
                        <option value="{{ $categoria->id }}"><?= $categoria->id, " - ", $categoria->nome ?></option>
                        <?php endforeach;
                ?>
            </select>
            <label for="floatingSelect2">Categorias de produtos</label>
          </div>

          <div class="text-center mt-3">
            <label for="descricao">Descrição do produto</label> <br>
            <textarea name="descricao" class="w-25 p-3" placeholder="Digite a descrição do produto" maxlength="100"></textarea>
          </div>

          <div class="text-center mt-3">
            <label for="precoVendaAtual">Valor do produto</label>
            <input type="number" class="form-group" name="precoVendaAtual" id="precoVendaAtual">
        </div>

        <div class="text-center mt-3">
        <button type="submit" class="bnt bnt-primary">Salvar</button>
        </div>

    </form>

@endsection
