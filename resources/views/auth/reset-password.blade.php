<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar senha</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="\imagens\sleeping-baby.svg" class="left-login-image" alt="Bebê animação">
        </div>
        <form action="{{route('password.update')}}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <div class="right-login">
                <div class="card-login">
                        <h1>Resetar senha</h1>
                        <div class="textfield">
                            <label for="email">Email</label>
                            <input type="email" required name="email" placeholder="Email">
                        </div>
                        <div class="textfield">
                            <label for="password">Nova senha</label>
                            <input type="password" required name="password" placeholder="Nova senha">
                        </div>
                        <div class="textfield">
                            <label for="password_confirmation">Confirmar nova senha</label>
                            <input type="password" required name="password_confirmation" placeholder="Nova senha">
                        </div>
                        <button type="submit" name="botao-login" class="btn-login" >Enviar link</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @error('email')
        <script>
            swal("Ops!", "{!!$message!!}", "error",{
                button: "ok"
            });
        </script>
    @enderror

    @error('password')
        <script>
            swal("Ops!", "{!!$message!!}", "error",{
                button: "ok"
            });
        </script>
    @enderror

    @error('password_confirmation')
        <script>
            swal("Ops!", "{!!$message!!}", "error",{
                button: "ok"
            });
        </script>
    @enderror

    @if(session()->has('status'))
        <script>
            swal("Concluído!", "{!!session()->get('status')!!}", "success",{
                button: "ok"
            });
        </script>
    @endif

</html>
