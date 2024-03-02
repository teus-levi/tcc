<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório de Vencimento</title>
    <style>
        table tr td,
        table tr th{
            padding: 10px 15px;
        }
    </style>
</head>
<body>
        <h1 style="text-align: center">Relatório de Produtos Vencidos</h1>
        <p style="text-align: center">Listagem com os estoques vencidos</p>
    <hr>
    <table style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr style="background-color: #adb5bd;">
                <th style="border: 1px solid #ccc;">ID</th>
                <th style="border: 1px solid #ccc;">Produto</th>
                <th style="border: 1px solid #ccc;">Marca</th>
                <th style="border: 1px solid #ccc;">Categoria</th>
                <th style="border: 1px solid #ccc;">ID Estoque</th>
                <th style="border: 1px solid #ccc;">Data Vencimento</th>
                <th style="border: 1px solid #ccc;">Desativado</th>
            </tr>
            <tbody>
                @foreach ($vencidos as $item)
                    <tr>
                        <th style="border: 1px solid #ccc; border-top: none; ">{{$item->id}}</th>
                        <th style="border: 1px solid #ccc; border-top: none;">{{$item->nome}}</th>
                        <th style="border: 1px solid #ccc; border-top: none;">{{$item->n_marca}}</th>
                        <th style="border: 1px solid #ccc; border-top: none;">{{$item->n_categoria}}</th>
                        <th style="border: 1px solid #ccc; border-top: none;">{{$item->estoque}}</th>
                        <th style="border: 1px solid #ccc; border-top: none;">{{$item->validade}}</th>
                        <th style="border: 1px solid #ccc; border-top: none;">
                            @if (is_null($item->deleted_at))
                                Não
                            @else
                                Sim
                            @endif
                        </th>
                    </tr>

                @endforeach

            </tbody>
        </thead>
    </table>
</body>

</html>

