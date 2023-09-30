@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Estoque
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Estoque</h2>
    


<div class="container">
    <div class="d-flex justify-content-end">
    <form action="/listarProdutos" method="get">
        <button class="btn btn-success">
            <i class="fa-solid fa-plus"></i>
        </button>
    </form>
    </div>
    <hr>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Lote</th>
                <th>Validade</th>
                <th>Ação</th>
            </tr>
            <tbody>
                @foreach ($estoque as $item)
                    <tr>
                        {{ $produto = Produto::find($item->produto) }}
                        <th>{{$item->id}}</th>
                        <th>{{$produto->nome}}</th>
                        <th>{{$item->quantidade}}</th>
                        <th>{{$item->precoCompra}}</th>
                        <th>{{$item->lote}}</th>
                        <th>{{$item->validade}}</th>
                        <th>{{$item->id}}</th>
                    </tr>
                @endforeach
                
            </tbody>
        </thead>
    </table>
</div>
@endsection