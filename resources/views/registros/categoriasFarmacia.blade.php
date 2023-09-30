@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Categorias
@endsection


@section('conteudo')
    <form action="/registrarCategorias" method="post" enctype="multipart/form-data">
        @csrf
        <div class="text-center mt-3">
            <label for="nome">Nome da Categoria</label>
            <input type="text" class="form-group" name="nome" id="nome">
        </div>
        <div class="text-center mt-3">
        <button type="submit" class="bnt bnt-primary">Salvar</button>
        </div>

    </form>

@endsection
