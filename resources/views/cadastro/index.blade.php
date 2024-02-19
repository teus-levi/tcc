<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset ('css/cadastrar.css') }}">
    <title>Cadastrar</title>
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="imagens\cadastrar-baby.svg" class="left-login-image" alt="Cadastrar imagem">
        </div>

        <!-- Modal -->
@if(!empty($mensagem))
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Erro!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php echo $mensagem ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
    </div>
@endif

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

        <form action="/cadastrar2" method="get">
            @csrf

            <div class="right-login">
                <div class="card-login">
                    <h1>CADASTRO</h1>
                    <div class="textfield">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{old('email')}}" placeholder="Email">
                    </div>
                    <div class="textfield">
                        <label for="email_confirmation">Confirmar email</label>
                        <input type="email" name="email_confirmation"  value="{{old('email_confirmation')}}" placeholder="Confirmar email">
                    </div>
                    <div class="textfield">
                        <label for="password">Senha</label>
                        <input type="password" name="password" value="{{old('password')}}" placeholder="Senha">
                    </div>
                    <div class="textfield">
                        <label for="password_confirmation">Confirmar senha</label>
                        <input type="password" name="password_confirmation" value="{{old('password_confirmation')}}" placeholder="Confirmar senha">
                    </div>
                    <button class="btn-login" type="submit">Continuar</button>
                    <p>Etapa 1/2</p>
                </div>
            </div>
        </form>
    </div>
</body>
@if(!empty($mensagem))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        keyboard: false
    })
    myModal.show();
    /*
    if(window.Notification&&Notification.permission!=="denied"){
        Notification.requestPermission(function(status){
            let n = new Notification('Erro!', {
                body: '{{ $mensagem }}'
            })
        })
    }*/
</script>
@endif

@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('exampleModal2'), {
        keyboard: false
    })
    myModal.show();
    /*
    if(window.Notification&&Notification.permission!=="denied"){
        Notification.requestPermission(function(status){
            let n = new Notification('Erro!', {
                body: '{{ $mensagem }}'
            })
        })
    }*/
</script>
@endif
</html>
