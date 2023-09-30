@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Administradores
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Usuários</h2>





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

@endsection