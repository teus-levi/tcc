@extends('layout')

@section('titulo')
    BabyOn - Ediçao de Perfil
@endsection
@section('conteudo')
<main class="flex-fill">
    <div class="container">
        <h1 class="mt-4">Alterar senha</h1>
        <div class="row gx-3">
            <div class="col-4">
                <div class="list-group">
                    <a href="{{route('editarPerfil')}}" class="list-group-item list-group-item-action">
                        <i class="bi-person fs-6"></i> Perfil
                    </a>
                    <a href="{{route('editarEndereco')}}" class="list-group-item list-group-item-action">
                        <i class="bi-house-door fs-6"></i> Endereço
                    </a>
                    <a href="{{route('listarPedidos')}}" class="list-group-item list-group-item-action">
                        <i class="bi-truck fs-6"></i> Pedidos
                    </a>
                    <a href="{{route('editarSenha')}}" class="list-group-item list-group-item-action bg-primary text-light">
                        <i class="bi-lock fs-6"></i> Alterar Senha
                    </a>
                    <a href="/sair" class="list-group-item list-group-item-action">
                        <i class="bi-door-open fs-6"></i> Sair
                    </a>
                </div>
            </div>

            @if($errors->any())
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Erro!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-8">
                <form class="col-sm-12 col-md-8 col-lg-6" action="/storeSenha" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="password" id="txtSenha" name="password" class="form-control" placeholder=" ">
                        <label for="txtSenha">Digite aqui sua nova senha</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password_confirmation" id="txtConfSenha" class="form-control" placeholder=" ">
                        <label for="txtConfSenha">Redigite aqui a nova senha</label>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary">Alterar Senha</button>
                </form>
            </div>
        </div>
    </div>
</main>

@push('validacao')
@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal2'), {
        keyboard: false
    })
    myModal.show();
</script>
@endif
@endpush

@endsection
