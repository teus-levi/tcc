<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="imagens\sleeping-baby.svg" class="left-login-image" alt="Bebê animação">
        </div>
        <form action="{{route('password.email')}}" method="POST">
            @csrf
            <div class="right-login">
                <div class="card-login">
                        <h1>Recuperar senha</h1>
                        <div class="textfield">
                            <label for="email">Email</label>
                            <input type="email" required name="email" id="email" placeholder="Email">
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

    @if(session()->has('status'))
        <script>
            swal("Concluído!", "{!!session()->get('status')!!}", "success",{
                button: "ok"
            });
        </script>
    @endif

</html>
