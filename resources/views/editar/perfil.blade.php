@extends('layout')

@section('titulo')
    BabyOn - Ediçao de Perfil
@endsection
@section('conteudo')
<main class="flex-fill">
    <div class="container">

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

        <h1 class="mt-4">Minha conta</h1>
        <div class="row gx-3">
            <div class="col-4">
                <div class="list-group">
                    <a href="{{route('editarPerfil')}}" class="list-group-item list-group-item-action bg-primary text-light">
                        <i class="bi-person fs-6"></i> Perfil
                    </a>
                    <a href="{{route('editarEndereco')}}" class="list-group-item list-group-item-action">
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
                <form action="/storePerfil/{{$perfil[0]->usuario}}" method="post">
                    @csrf
                    <div class="form-floating mb-3">
                        <input class="form-control" value="{{$perfil[0]->name}}" type="text" id="nome" name="nome" placeholder=" " autofocus />
                        <label for="nome">Nome</label>
                    </div>
                    <div class="form-floating mb-3 col-md-6 col-xl-4">
                        <input class="form-control cpf" value="{{$perfil[0]->CPF}}" type="text" id="CPF" name="CPF" placeholder=" " />
                        <label for="CPF">CPF</label>
                    </div>
                    <div class="form-floating mb-3 col-md-6 col-xl-4">
                        <input class="form-control telefone" value="{{$perfil[0]->telefone}}" type="text" id="telefone" name="telefone" placeholder=" " />
                        <label for="telefone">Telefone</label>
                    </div>
                    <div class="form-floating mb-3 col-md-6 col-xl-4">
                        <input class="form-control" type="date" value="{{$perfil[0]->dataNascimento}}" id="dataNascimento" name="dataNascimento" placeholder=" " />
                        <label for="dataNascimento">Data de Nascimento</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $('.cpf').mask('000.000.000-00');
    $('.telefone').mask('(00) 00000-0000');
</script>
@endpush

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
