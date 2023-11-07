@extends('layout')

@section('titulo')
    BabyOn - Ediçao de Perfil
@endsection
@section('conteudo')
<main class="flex-fill">
    <div class="container">
        <h1 class="mt-4">Minha conta</h1>
        <div class="row gx-3">
            <div class="col-4">
                <div class="list-group">
                    <a href="{{route('editarPerfil')}}" class="list-group-item list-group-item-action">
                        <i class="bi-person fs-6"></i> Perfil
                    </a>
                    <a href="{{route('editarEndereco')}}" class="list-group-item list-group-item-action bg-primary text-light">
                        <i class="bi-house-door fs-6"></i> Endereço
                    </a>
                    <a href="{{route('listarPedidos')}}" class="list-group-item list-group-item-action">
                        <i class="bi-truck fs-6"></i> Pedidos
                    </a>
                    <a href="{{route('editarSenha')}}" class="list-group-item list-group-item-action">
                        <i class="bi-lock fs-6"></i> Alterar Senha
                    </a>
                    <a href="/sair" class="list-group-item list-group-item-action">
                        <i class="bi-door-open fs-6"></i> Sair
                    </a>
                </div>
            </div>
            <div class="col-8">
                <form action="/storeEndereco/{{$endereco[0]->usuario}}" method="post">
                    @csrf
                    @if(isset($endereco[0]->logradouro))
                        @livewire('endereco', ['endereco' => $endereco[0]])
                    @else
                        @livewire('endereco')
                    @endif
                    <div class="d-flex">
                        <button type="submit" class="btn btn-success">Salvar</button>                 
        
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</main>
@endsection