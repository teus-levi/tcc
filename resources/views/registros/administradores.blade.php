@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Administradores
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Usuários</h2>
<div class="container">
    <div class="row gx-3">
        <div class="col-12">
            <form method="POST" class="row mb-3 mt-3" action="/filtrarAdministradores">
                @csrf
                @if(isset($filtros))
                    <div class="w-100 col-12 col-md-6 d-flex justify-content-center">
                        <div class="input-group input-group w-25 me-3">
                            <input type="text" value="{{$filtros['pesquisa']}}" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do usuário">
                        </div>
                        <button type="submit" class="btn btn-primary w-25 ">Pesquisar</button>
                    </div>
                @else
                    <div class="w-100 col-12 col-md-6 d-flex justify-content-center">
                        <div class="input-group input-group w-25 me-3">
                            <input type="text" name="pesquisa" class="form-control" placeholder="Digite aqui o nome ou email">
                        </div>
                        <button type="submit" class="btn btn-primary w-25 ">Pesquisar</button>
                    </div>
                @endif
            </form>
        </div>
        </div>



    <div class="text-center mt-3 w-75 mx-auto d-block">
                    <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe" data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap data-tablesaw-mode-switch>
                        <thead>
                            <tr>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="persist">ID</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col data-tablesaw-priority="3">Nome</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">Email</th>
                                <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="1">Ação</th>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                            <tr>
                                <td class="title">{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                @if($usuario->administrador == 0)
                                    <form action="/registrarAdministradores/{{ $usuario->id }}" method="POST"
                                        onsubmit="return confirm('Confirma adicionar o usuário {{ $usuario->name }} como administrador?')">
                                        @csrf
                                        <td>
                                        <button class="btn btn-success btn-sm"> <i class="fas fa-user-plus"></i> Adicionar</button>
                                        </td>
                                    </form>
                                @else
                                    <form action="/removerAdministradores/{{ $usuario->id }}" method="POST"
                                        onsubmit="return confirm('Confirma remover o usuário {{ $usuario->name }} como administrador?')">
                                        @csrf
                                        <td>
                                        <button class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> Remover</button>
                                        </td>
                                    </form>
                                @endif
                            @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (isset($filtros))
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$usuarios->appends($filtros)->links()}}
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$usuarios->links()}}
            </div>
        </div>
    @endif
</div>
@endsection
