<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/cadastrar.css') }}">
    <title>Cadastrar Farmácia</title>
</head>
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>BabyOn</h1>
            <img src="imagens\cadastrar2.svg" class="left-login-image" alt="Cadastrar imagem">
        </div>
        <form action="/storeFarmacia" method="post">
            @csrf
            <div class="right-login">
                <div class="card-login">
                    <h1>CADASTRO DE FARMÁCIA</h1>
                    <div class="textfield">
                        <label for="endereco">Logradouro</label>
                        <input type="text" name="endereco" placeholder="Endereço">
                    </div>
                    <div class="textfield">
                        <label for="numero">Número</label>
                        <input type="number" name="numero" placeholder="Número">
                    </div>
                    <div class="textfield">
                        <label for="cep">CEP</label>
                        <input type="number" name="cep" placeholder="CEP">
                    </div>
                    <div class="textfield">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" placeholder="Bairro">
                    </div>
                    <div class="textfield">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" placeholder="Cidade">
                    </div>
                    <div class="textfield">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" placeholder="Estado">
                    </div>
                    <button class="btn-login">Finalizar</button>
                    <p>Etapa 3/3</p>
                </div>
            </div>
        </form>
    </div>
</body>
</html>