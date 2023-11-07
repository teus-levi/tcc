@extends('layout')

@section('titulo')
    BabyOn - Ediçao de Perfil
@endsection
@section('conteudo')
<main class="flex-fill">
    <div class="container">
        <h1 class="mt-4">Minha conta</h1>
        <div class="row gx-3">
            <div class="col-4">
                <div class="list-group">
                    <a href="{{route('editarPerfil')}}" class="list-group-item list-group-item-action">
                        <i class="bi-person fs-6"></i> Perfil
                    </a>
                    <a href="{{route('editarEndereco')}}" class="list-group-item list-group-item-action">
                        <i class="bi-house-door fs-6"></i> Endereço
                    </a>
                    <a href="{{route('listarPedidos')}}" class="list-group-item list-group-item-action bg-primary text-light">
                        <i class="bi-truck fs-6"></i> Pedidos
                    </a>
                    <a href="{{route('editarSenha')}}" class="list-group-item list-group-item-action">
                        <i class="bi-lock fs-6"></i> Alterar Senha
                    </a>
                    <a href="/sair" class="list-group-item list-group-item-action">
                        <i class="bi-door-open fs-6"></i> Sair
                    </a>
                </div>
            </div>
            <div class="col-8">
                <form class="row mb-3">
                    <div class="col-12 col-md-6 mb-3">
                        <div class="form-floating">
                            <select class="form-select">
                                <option value="30">Últimos 30 dias</option>
                                <option value="60">Últimos 60 dias</option>
                                <option value="90">Últimos 90 dias</option>
                                <option value="180">Últimos 180 dias</option>
                                <option value="360" selected>Últimos 360 dias</option>
                                <option value="9999">Todo o período</option>
                            </select>
                            <label>Período</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-floating">
                            <select class="form-select">
                                <option value="1" selected>Mais novos primeiro</option>
                                <option value="2">Mais antigos primeiro</option>
                            </select>
                            <label>Ordenação</label>
                        </div>
                    </div>
                </form>
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#pedido000010">
                                <b>Pedido 000010</b>
                                <span class="mx-1">(realizado em 07/11/2023)</span>
                            </button>
                        </div>
                        <div id="pedido000010" class="accordion-collapse collapse" data-bs-parent="#divPedidos">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th class="text-end">R$ Unit.</th>
                                            <th class="text-center">Qtde.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Produto 1</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 2</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 3</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="3">Valor Total:</th>
                                            <td class="text-end">26,91</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="3">Forma de Pagamento:</th>
                                            <td class="text-end">Crédito VISA 1x</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="5">
                                            <button class="btn btn-outline-warning ">Ver detalhes</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#pedido000009">
                                <b>Pedido 000009</b>
                                <span class="mx-1">(realizado em 07/11/2023)</span>
                            </button>
                        </div>
                        <div id="pedido000009" class="accordion-collapse collapse" data-bs-parent="#divPedidos">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th class="text-end">R$ Unit.</th>
                                            <th class="text-center">Qtde.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Produto 1</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 2</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 3</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="3">Valor Total:</th>
                                            <td class="text-end">26,91</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="3">Forma de Pagamento:</th>
                                            <td class="text-end">Crédito VISA 1x</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="5">
                                            <button class="btn btn-outline-warning ">Ver detalhes</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#pedido000008">
                                <b>Pedido 000008</b>
                                <span class="mx-1">(realizado em 07/11/2023)</span>
                            </button>
                        </div>
                        <div id="pedido000008" class="accordion-collapse collapse" data-bs-parent="#divPedidos">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th class="text-end">R$ Unit.</th>
                                            <th class="text-center">Qtde.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Produto 1</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 2</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 3</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="3">Valor Total:</th>
                                            <td class="text-end">26,91</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="3">Forma de Pagamento:</th>
                                            <td class="text-end">Crédito VISA 1x</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="5">
                                            <button class="btn btn-outline-warning ">Ver detalhes</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#pedido000007">
                                <b>Pedido 000007</b>
                                <span class="mx-1">(realizado em 07/11/2023)</span>
                            </button>
                        </div>
                        <div id="pedido000007" class="accordion-collapse collapse" data-bs-parent="#divPedidos">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th class="text-end">R$ Unit.</th>
                                            <th class="text-center">Qtde.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Produto 1</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 2</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 3</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="3">Valor Total:</th>
                                            <td class="text-end">26,91</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="3">Forma de Pagamento:</th>
                                            <td class="text-end">Crédito VISA 1x</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="5">
                                            <button class="btn btn-outline-warning ">Ver detalhes</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#pedido000006">
                                <b>Pedido 000006</b>
                                <span class="mx-1">(realizado em 07/11/2023)</span>
                            </button>
                        </div>
                        <div id="pedido000006" class="accordion-collapse collapse" data-bs-parent="#divPedidos">
                            <div class="accordion-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th class="text-end">R$ Unit.</th>
                                            <th class="text-center">Qtde.</th>
                                            <th class="text-end">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Produto 1</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 2</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                        <tr>
                                            <td>Produto 3</td>
                                            <td class="text-end">2,99</td>
                                            <td class="text-center">3</td>
                                            <td class="text-end">8,97</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-end" colspan="3">Valor Total:</th>
                                            <td class="text-end">26,91</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="3">Forma de Pagamento:</th>
                                            <td class="text-end">Crédito VISA 1x</td>
                                        </tr>
                                        <tr>
                                            <th class="text-end" colspan="5">
                                            <button class="btn btn-outline-warning ">Ver detalhes</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $('.cpf').mask('000.000.000-00');
    $('.telefone').mask('(00) 00000-0000');
</script>
@endpush

@endsection