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
                            <input type="email" required name="email" id="email" placeholder="Email">
                        </div>
                        <div class="textfield">
                            <label for="password">Senha</label>
                            <input type="password" required name="password"  id="password" placeholder="Senha">
                        </div>
                        <button type="submit" name="botao-login" class="btn-login" >Login</button>
                    <div style="margin-bottom: 7px">
                        <span style="color:white;">Não tem uma conta?</span> <a style=" text-decoration: underline whitesmoke" href="/cadastrar"> <strong>Cadastrar</strong></a>
                    </div>
                    <div>
                        <span style="color:white;">Esqueceu a senha?</span> <a style=" text-decoration: underline whitesmoke" href="/recuperarSenha"> <strong>Recuperar</strong></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>