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
            <div class="col-8">
                <form class="col-sm-12 col-md-8 col-lg-6" action="/storeSenha" method="POST">
                    <div class="form-floating mb-3">
                        <input type="password" id="txtSenhaAtual" class="form-control" placeholder=" " autofocus>
                        <label for="txtSenhaAtual">Digite aqui sua senha atual</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" id="txtSenha" class="form-control" placeholder=" ">
                        <label for="txtSenha">Digite aqui sua nova senha</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" id="txtConfSenha" class="form-control" placeholder=" ">
                        <label for="txtConfSenha">Redigite aqui a nova senha</label>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary">Alterar Senha</button>
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

@endsection