<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/cadastrar.css') }}">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="imagens\cadastrar2.svg" class="left-login-image" alt="Cadastrar imagem">
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

        <form action="/storeCliente" method="post">
            @csrf
            <div class="right-login">
                <div class="card-login">
                    <h1>CADASTRO DE USUÁRIO</h1>
                    <div class="textfield">
                        <label for="nomeCompleto">Nome completo</label>
                        <input type="text" name="nomeCompleto" value="{{old('nomeCompleto')}}" placeholder="Nome completo">
                    </div>
                    <div class="textfield">
                        <label for="cpf">CPF</label>
                        <input id="cpf" type="text" name="cpf" value="{{old('cpf')}}" placeholder="CPF">
                    </div>
                    <div class="textfield">
                        <label for="dataNascimento">Data de nascimento</label>
                        <input type="date" name="dataNascimento" value="{{old('dataNascimento')}}" placeholder="Data de nascimento">
                    </div>
                    <div class="textfield">
                        <label for="telefone">Telefone</label>
                        <input id="telefone" type="text" name="telefone" value="{{old('telefone')}}" placeholder="Telefone">
                    </div>
                    <button class="btn-login">Finalizar</button>
                    <p>Etapa 2/2</p>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 00000-0000');
</script>

@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal2'), {
        keyboard: false
    })
    myModal.show();
</script>
@endif
</html>
