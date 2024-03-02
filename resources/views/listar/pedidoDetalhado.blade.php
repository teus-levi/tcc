@extends('layout')

@section('titulo')
    BabyOn - Listagem do pedido
@endsection

@section('conteudo')
<main class="flex-fill">
    <div class="container">
        <h2 style="margin-left: 0%;" class="text-center">Detalhes do pedido</h2>
        <hr>
        <div class="mt-3">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <fieldset class="row gx-3">
                        <legend>Dados Pessoais</legend>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly type="text" value="{{$pedido->nomeRecebedor}}" id="txtNome" placeholder=" " autofocus />
                            <label for="txtNome">Nome Recebedor</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly type="text" value="{{$pedido->getUser->name}}" id="txtNomeComprador" placeholder=" " autofocus />
                            <label for="txtNomeComprador">Nome comprador</label>
                        </div>
                        <div class="form-floating mb-3 col-md-6 col-xl-4">
                            <input class="form-control cpf" readonly value="{{$pedido->getUser->getCliente->CPF}}" type="text" id="txtCPF" placeholder=" " />
                            <label for="txtCPF" >CPF</label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Contatos</legend>
                        <div class="form-floating mb-3 col-md-8">
                            <input class="form-control" readonly type="email" value="{{$pedido->getUser->email}}" id="txtEmail" placeholder=" " />
                            <label for="txtEmail">E-mail</label>
                        </div>
                        <div class="form-floating mb-3 col-md-6">
                            <input class="form-control telefone" readonly value="{{$pedido->getUser->getCliente->telefone}}" placeholder=" " type="text" id="txtTelefone" />
                            <label for="txtTelefone">Telefone</label>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm-12 col-md-6">
                    <fieldset class="row gx-3">
                        <legend>Endereço da entrega</legend>
                        <div class="form-floating mb-3 col-md-6 col-lg-4">
                            <input class="form-control" readonly type="text" value="{{$pedido->CEP}}" id="txtCEP" placeholder=" " />
                            <label for="txtCEP" >CEP</label>
                        </div>
                        <div class="form-floating mb-3 col-md-8">
                            <input class="form-control" readonly type="text" value="{{$pedido->cidade . " - " . $pedido->estado}}" id="cidadeEstado" placeholder=" " />
                            <label for="cidadeEstado" >Cidade - Estado</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly value="{{$pedido->logradouro}}" type="text" id="logradouro" placeholder=" " />
                            <label for="logradouro">Logradouro</label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-floating mb-3 col-md-4">
                            <input class="form-control" readonly type="text" value="{{$pedido->numero}}" id="txtNumero" placeholder=" " />
                            <label for="txtNumero">Número</label>
                        </div>
                        <div class="form-floating mb-3 col-md-8">
                            <input class="form-control" readonly type="text" value="{{$pedido->bairro}}" id="bairro" placeholder=" " />
                            <label for="bairro">Bairro</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly type="text" value="{{$pedido->descricao}}" id="txtReferencia" placeholder=" " />
                            <label for="txtReferencia">Observação</label>
                        </div>
                    </fieldset>
                </div>
            </div>
            <legend class="mt-5">Produto(s)</legend>
            <hr>
            <table class="table table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID produto</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Marca</th>
                        <th>Preço unt.</th>
                        <th>Quantidade</th>
                        <th>Preço total</th>
                    </tr>
                    <tbody>
                        <?php
                            $produtos =  $pedido->getItens;
                            $valorTotal = 0;
                        ?>
                        @if(!empty($produtos))
                        @foreach ($produtos as $item)
                            <?php
                                $valorTotal += ($item->quantidade * $item->valorUnitario);
                            ?>
                            <tr>
                                <th>{{$item->produto}}</th>
                                <th>
                                    <div style="width: 7em; height: 7em;" class="d-block">
                                    <img src="/storage/{{$item->getProdutoDeleted->imagem}}" class="img-fluid" alt="...">
                                    </div>
                                </th>
                                <th>{{$item->getProdutoDeleted->nome}}</th>
                                <th>{{$item->getProdutoDeleted->getMarca->nome}}</th>
                                <th class="preco">{{$item->valorUnitario}}</th>
                                <th>
                                    @if(!is_null($item->quantidade))
                                        {{$item->quantidade}}
                                    @else
                                        0
                                    @endif
                                </th>
                                <th>
                                    {{number_format(($item->quantidade * $item->valorUnitario) / 100, 2, ",", ".")}}
                                </th>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </thead>
            </table>
            <legend class="mt-5">Geral</legend>
            <hr>

                <div class="row mb-3 g-3">

                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control" type="text" readonly value="{{$pedido->modoRecebimento}}" id="pagamento" placeholder=" " />
                        <label for="pagamento" >Modo de pagamento</label>
                    </div>
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control preco" readonly type="text" value="{{$valorTotal}}" id="valorTotal" placeholder=" " />
                        <label for="valorTotal" >Valor total</label>
                    </div>
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control" type="number" readonly value="{{$pedido->parcelas}}" id="parcelas" placeholder=" " name="parcelas"/>
                        <label for="parcelas">Parcelas</label>
                    </div>
                    <div class="form-floating mb-3 col-3">
                        <input class="form-control" type="date" readonly value="{{$pedido->vencimento}}" id="vencimento" placeholder=" " name="vencimento"/>
                        <label for="vencimento">Vencimento</label>
                    </div>
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control" value="{{$pedido->statusEntrega}}" readonly type="text" id="" placeholder=" " name="" />
                        <label for="saldo">Status da entrega</label>
                    </div>
                    @if($pedido->statusEntrega == "Cancelado.")
                        <div class="form-floating mb-3 col-sm-12 col-md-4">
                            <input class="form-control" value="{{$pedido->descDelete}}" readonly type="text" id="" placeholder=" " name="" />
                            <label for="saldo">Motivo Cancelamento</label>
                        </div>
                    @endif

                </div>

                <div class="mb-3 text-left mb-5 d-flex">
                    <a class="btn btn-lg btn-light btn-outline-primary me-3" href="{{route('listarPedidos')}}">Voltar</a>
                    @if($pedido->statusEntrega == "Em preparação." || $pedido->statusEntrega == "Aguardando pix.")
                        <form class="deleteAlert" action="/storeEditPedido/{{$pedido->id}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-lg btn-danger">Cancelar Pedido</button>
                        </form>
                    @endif
                </div>

        </div>
    </div>
</main>
@endsection
@push('scripts')

<script>
      $('.deleteAlert').on('submit', function(e){
    e.preventDefault();
    swal({
      title: "Atenção!",
      text: "Seu pedido será cancelado imediatamente. Deseja confirmar o cancelamento?",
      icon: "warning",
      buttons: ["Voltar", "Confirmar"],
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        this.submit()
      }
    });
  })
</script>
@endpush
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $('.preco').mask("#.##0,00", {reverse: true});
      $('.telefone').mask('(00) 00000-0000');
      $('.cpf').mask('000.000.000-00');
  </script>
@endpush
