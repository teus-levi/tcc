@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Marcas
@endsection


@section('conteudo')
    <form action="/registrarMarcas" method="post" enctype="multipart/form-data">
        @csrf
        <div class="text-center mt-3">
            <label for="nome">Nome da marca</label>
            <input type="text" class="form-group" name="nome" id="nome">
        </div>
        <div class="text-center mt-3">
        <button type="submit" class="bnt bnt-primary">Salvar</button>
        </div>

    </form>

@endsection
