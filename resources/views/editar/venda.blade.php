@extends('layout')

@section('titulo')
    BabyOn - Ediçao da Venda
@endsection

@section('conteudo')
<main class="flex-fill">
    <div class="container">
        <h2 style="margin-left: 0%;" class="text-center">Venda</h2>
        <hr>
        <div class="mt-3">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <fieldset class="row gx-3">
                        <legend>Dados Pessoais</legend>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly type="text" value="{{$venda->nomeRecebedor}}" id="txtNome" placeholder=" " autofocus />
                            <label for="txtNome">Nome Recebedor</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly type="text" value="{{$venda->getUser->name}}" id="txtNomeComprador" placeholder=" " autofocus />
                            <label for="txtNomeComprador">Nome comprador</label>
                        </div>
                        <div class="form-floating mb-3 col-md-6 col-xl-4">
                            <input class="form-control cpf" readonly value="{{$venda->getUser->getCliente->CPF}}" type="text" id="txtCPF" placeholder=" " />
                            <label for="txtCPF" >CPF</label>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Contatos</legend>
                        <div class="form-floating mb-3 col-md-8">
                            <input class="form-control" readonly type="email" value="{{$venda->getUser->email}}" id="txtEmail" placeholder=" " />
                            <label for="txtEmail">E-mail</label>
                        </div>
                        <div class="form-floating mb-3 col-md-6">
                            <input class="form-control telefone" readonly value="{{$venda->getUser->getCliente->telefone}}" placeholder=" " type="text" id="txtTelefone" />
                            <label for="txtTelefone">Telefone</label>
                        </div>
                    </fieldset>
                </div>
                <div class="col-sm-12 col-md-6">
                    <fieldset class="row gx-3">
                        <legend>Endereço da entrega</legend>
                        <div class="form-floating mb-3 col-md-6 col-lg-4">
                            <input class="form-control" readonly type="text" value="{{$venda->CEP}}" id="txtCEP" placeholder=" " />
                            <label for="txtCEP" >CEP</label>
                        </div>
                        <div class="form-floating mb-3 col-md-8">
                            <input class="form-control" readonly type="text" value="{{$venda->cidade . " - " . $venda->estado}}" id="cidadeEstado" placeholder=" " />
                            <label for="cidadeEstado" >Cidade - Estado</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly value="{{$venda->logradouro}}" type="text" id="logradouro" placeholder=" " />
                            <label for="logradouro">Logradouro</label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-floating mb-3 col-md-4">
                            <input class="form-control" readonly type="text" value="{{$venda->numero}}" id="txtNumero" placeholder=" " />
                            <label for="txtNumero">Número</label>
                        </div>
                        <div class="form-floating mb-3 col-md-8">
                            <input class="form-control" readonly type="text" value="{{$venda->bairro}}" id="bairro" placeholder=" " />
                            <label for="bairro">Bairro</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" readonly type="text" value="{{$venda->descricao}}" id="txtReferencia" placeholder=" " />
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
                            $produtos =  $venda->getItensDeleted;
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
                                    <img src="/storage/{{$item->getProduto->imagem}}" class="img-fluid" alt="...">
                                    </div>
                                </th>
                                <th>{{$item->getProduto->nome}}</th>
                                <th>{{$item->getProduto->getMarca->nome}}</th>
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
            <legend class="mt-5">Gerencial</legend>
            <hr>
            <form action="/storeEditVenda/{{$venda->id}}" method="POST">
                @csrf
                <div class="row mb-3 g-3">
                            
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control" type="text" readonly value="{{$venda->modoRecebimento}}" id="pagamento" placeholder=" " />
                        <label for="pagamento" >Modo de pagamento</label>
                    </div>
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control preco" readonly type="text" value="{{$valorTotal}}" id="valorTotal" placeholder=" " />
                        <label for="valorTotal" >Valor total</label>
                    </div>
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control" type="number" value="{{$venda->parcelas}}" id="parcelas" placeholder=" " name="parcelas"/>
                        <label for="parcelas">Parcelas</label>
                    </div>
                    <div class="form-floating mb-3 col-sm-12 col-md-4">
                        <input class="form-control preco" value="{{$venda->saldoReceber}}" type="text" id="saldo" placeholder=" " name="saldo" />
                        <label for="saldo">Saldo a receber</label>
                    </div>
                    <div class="form-floating mb-3 col-3">
                        <input class="form-control" type="date" value="{{$venda->vencimento}}" id="vencimento" placeholder=" " name="vencimento"/>
                        <label for="vencimento">Vencimento</label>
                    </div>
                    <div class="mb-3 col-4">
                        <label>Status da entrega:</label>
                        <select class="form-select" aria-label="Selecionar o status" name="status">
                            <option value="Em preparação." {{$venda->statusEntrega == "Em preparação." ? 'selected' : ''}}>Em preparação.</option>
                            <option value="Cancelado." {{$venda->statusEntrega == "Cancelado." ? 'selected' : ''}}>Cancelado.</option>
                            <option value="Aguardando pix." {{$venda->statusEntrega == "Aguardando pix." ? 'selected' : ''}}>Aguardando pix.</option>
                            <option value="Em transporte." {{$venda->statusEntrega == "Em transporte." ? 'selected' : ''}}>Em transporte.</option>
                            <option value="Entregue." {{$venda->statusEntrega == "Entregue." ? 'selected' : ''}}>Entregue.</option>
                        </select>
                                    
                    </div>
                    @if($venda->statusEntrega =="Cancelado.")
                    <div class="form-floating mb-3">
                        <input class="form-control" type="text" value="{{$venda->descDelete}}" id="cancelamento" placeholder=" "/>
                        <label for="cancelamento">Motivo do cancelamento</label>
                    </div>
                    @endif
                </div>
            
                
                <div class="mb-3 text-left mb-5">
                    <a class="btn btn-lg btn-light btn-outline-primary" href="{{route('listarVendas')}}">Voltar</a>
                    @if($venda->statusEntrega !="Cancelado.")
                    <a href="#delete{{$venda->id}}" data-bs-toggle="modal" class="btn btn-lg btn-danger"> Cancelar</a>    

                                
                    <button type="submit" class="btn btn-lg btn-success">Salvar</button>
                    @endif
                </div>
                
            </form>

            <!-- MODAL --> 
            <div class="modal fade" id="delete{{$venda->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cancelar venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <div class="modal-body ">
                        <form action="/removerVenda/{{$venda->id}}" method="POST">
                            @csrf
                            <p class=" d-flex justify-content-center">Informe o motivo do cancelamento da venda {{$venda->id}}:</p>
                            <input type="text" name="motivo" style="width: 100%;">
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Salvar</button>
                        </form>
                        </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $('.preco').mask("#.##0,00", {reverse: true});
      $('.telefone').mask('(00) 00000-0000');
      $('.cpf').mask('000.000.000-00');
  </script>
@endpush
