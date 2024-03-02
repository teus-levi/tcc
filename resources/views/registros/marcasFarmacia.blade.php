@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Marcas
@endsection


@section('conteudo')
<h2 style="margin-left: 0%;" class="text-center">Marca</h2>
                    <p class="text-muted text-center mb-5">Faça a inclusão de uma nova marca</p>
    <form action="/registrarMarcas" method="post" enctype="multipart/form-data">
        @csrf
        <div class="text-center mt-3">
            <label for="nome">Nome:</label>
            <input type="text" class="form-group" name="nome" id="nome">
        </div>
        <div class="text-center mt-3">
            <a href="/listarMarcas" class="btn btn-secondary mt-3">
                Voltar
            </a>
        <button type="submit" class="btn btn-success mt-3">Salvar</button>
        </div>

    </form>

@endsection
