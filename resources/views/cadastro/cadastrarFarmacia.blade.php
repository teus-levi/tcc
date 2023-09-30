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
            <img src="\imagens\cadastrarFarmacia.svg" class="left-login-image" alt="Cadastrar imagem">
        </div>
        <form action="/cadastrar3" method="post">
        @csrf
            <div class="right-login">
                <div class="card-login">
                    <h1>CADASTRO DE FARMÁCIA</h1>
                    <div class="textfield">
                        <label for="nomeFarmacia">Nome da farmácia</label>
                        <input type="text" name="nomeFarmacia" placeholder="Nome da farmácia">
                    </div>
                    <div class="textfield">
                        <label for="nomeResponsavel">Nome do responsável</label>
                        <input type="text" name="nomeResponsavel" placeholder="Nome do responsável">
                    </div>
                    <div class="textfield">
                        <label for="cnpj">CNPJ</label>
                        <input type="number" name="cnpj" placeholder="CNPJ">
                    </div>
                    <div class="textfield">
                        <label for="telefoneResponsavel">Telefone do responsável</label>
                        <input type="number" name="telefoneResponsavel" placeholder="Telefone do responsável">
                    </div>
                    <div class="textfield">
                        <label for="telefoneFarmacia">Telefone da farmácia</label>
                        <input type="number" name="telefoneFarmacia" placeholder="Telefone da farmácia">
                    </div>
                    <button class="btn-login">Continuar</button>
                    <p>Etapa 2/3</p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>