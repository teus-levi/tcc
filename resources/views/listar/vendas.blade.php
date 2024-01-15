@extends('layout')

@section('titulo')
    BabyOn - Lista de Vendas
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Vendas</h2>
<div class="flex-fill">    
<div class="container">
    <div class="row gx-3">
    <div class="col-12">
        <form method="POST" class="row mb-3" action="/filtrarVendas">
            @csrf
            <div class="col-12 col-md-6 mb-3">
                <div class="form-floating">
                    
                    <select class="form-select" name="periodo">
                        <option value="30" {{$filtros['periodo'] == 30 ? 'selected' : ''}}>Últimos 30 dias</option>
                        <option value="60" {{$filtros['periodo']  == 60 ? 'selected' : ''}}>Últimos 60 dias</option>
                        <option value="90" {{$filtros['periodo']  == 90 ? 'selected' : ''}}>Últimos 90 dias</option>
                        <option value="180" {{$filtros['periodo']  == 180 ? 'selected' : ''}}>Últimos 180 dias</option>
                        <option value="360" {{$filtros['periodo']  == 360 ? 'selected' : ''}}>Últimos 360 dias</option>
                        <option value="9999" {{$filtros['periodo']  == 9999 ? 'selected' : ''}}>Todo o período</option>
                    </select>
                    <label>Período</label>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="form-floating">
                    <select class="form-select" name="ordenacao">
                        <option value="1" {{$filtros['ordenacao']  == 1 ? 'selected' : ''}}>Mais novos primeiro</option>
                        <option value="2" {{$filtros['ordenacao'] == 2 ? 'selected' : ''}}>Mais antigos primeiro</option>
                    </select>
                    <label>Ordenação</label>
                </div>
            </div>
            @if(isset($pesquisa))
                <div class="input-group input-group-sm">
                    <input type="text" value="{{$pesquisa}}" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do recebedor">
                </div>
            @else
                <div class="input-group input-group-sm">
                    <input type="text" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do recebedor">
                </div>
            @endif
            <div class="d-flex justify-content-end mt-2">
            <button type="submit" class="btn btn-primary w-25 ">Filtrar</button>
            </div>
        </form>
    </div>
    </div>
    <hr>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Nome do recebedor</th>
                <th>Quantidade</th>
                <th>Preço Total</th>
                <th>Status da entrega</th>
                <th>Data venda</th>
                <th>Status venda</th>
                <th>Ação</th>
            </tr>
            <tbody>
                @foreach ($vendas as $venda)
                <?php
                $total = 0; 
                $qtdProdutos = 0;
                $cancelada = 0;
                    $itens = $venda->getItens;
                    //dd($itens);
                    foreach ($itens as $produto) {
                        //dd($produto);
                        $qtdProdutos++;
                        $total += $produto->quantidade * $produto->valorUnitario;
                        //dd($qtdProdutos);
                    }
                ?>
                    <tr>
                        <th id="venda">{{$venda->id}}</th>
                        <th>{{$venda->nomeRecebedor}}</th>
                        <th>{{$qtdProdutos}}</th>
                        <th class="precoVendaAtual">{{$total}}</th>
                        <th>{{$venda->statusEntrega}}</th>
                        <th>{{$venda->created_at}}</th>
                        <th>
                            @if(!is_null($venda->deleted_at))
                                Cancelada <?php $cancelada = 1; ?>
                            @else
                                Ativa
                            @endif
                        </th>
                            <th>
                            <form action="/editarVenda/{{ $venda->id }}" method="GET">
                                @csrf
                                <button class="btn btn-warning btn-sm mb-2"> <i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            </form>
                            @if($cancelada != 1)
                                <a href="#delete{{$venda->id}}" data-bs-toggle="modal" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> Cancelar</a>    

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
                            @endif
                            </th>
                    </tr>
                @endforeach
                
            </tbody>
        </thead>
    </table>
    @if (isset($filtros))
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$vendas->appends($filtros)->links()}}
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$vendas->links()}}
            </div>
        </div>
    @endif
   

</div>
</div>
@endsection
@push('scripts')

<script>
      $('.deleteAlert').on('submit', function(e){
    e.preventDefault();
    swal({
      title: "Atenção!",
      text: "A venda será cancelada, o cliente será notificado por email. Deseja confirmar o cancelamento?",
      icon: "warning",
      buttons: ["Cancelar", "Confirmar"],
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
      $('.precoVendaAtual').mask("#.##0,00", {reverse: true});
  </script>
@endpush