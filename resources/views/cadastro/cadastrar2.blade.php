<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/cadastrar.css') }}">
    <title>Cadastrar Usuário</title>
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="imagens\cadastrar2.svg" class="left-login-image" alt="Cadastrar imagem">
        </div>
        <form action="/storeCliente" method="post">
            @csrf
            <div class="right-login">
                <div class="card-login">
                    <h1>CADASTRO DE USUÁRIO</h1>
                    <div class="textfield">
                        <label for="nomeCompleto">Nome completo</label>
                        <input type="text" name="nomeCompleto" placeholder="Nome completo">
                    </div>
                    <div class="textfield">
                        <label for="cpf">CPF</label>
                        <input type="number" name="cpf" placeholder="CPF">
                    </div>
                    <div class="textfield">
                        <label for="dataNascimento">Data de nascimento</label>
                        <input type="date" name="dataNascimento" placeholder="Data de nascimento">
                    </div>
                    <div class="textfield">
                        <label for="telefone">Telefone</label>
                        <input type="number" name="telefone" placeholder="Telefone">
                    </div>
                    <button class="btn-login">Finalizar</button>
                    <p>Etapa 2/2</p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>