<?php

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="imagens\sleeping-baby.svg" class="left-login-image" alt="Bebê animação">
        </div>
        <form action="/home" method="POST">
            @csrf
            <div class="right-login">
                <div class="card-login">
                        <h1>LOGIN</h1>
                        <div class="textfield">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="textfield">
                            <label for="password">password</label>
                            <input type="password" name="password"  id="password" placeholder="password">
                        </div>
                        <button type="submit" name="botao-login" class="btn-login" >Login</button>
                    Não tem uma conta? <a href="/cadastrar"> <strong>cadastre-se</strong></a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>