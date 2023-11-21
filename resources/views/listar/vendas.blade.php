@extends('layout')

@section('titulo')
    BabyOn - Lista de Vendas
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Vendas</h2>
    
<div class="container">
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
                        <th>{{$venda->id}}</th>
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
                            <form  class="deleteAlert" action="/removerVenda/{{ $venda->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> Excluir</button>    
                            </form>
                            @endif
                            </th>
                    </tr>
                @endforeach
                
            </tbody>
        </thead>
    </table>
    <div class="d-flex justify-content-center mb-5">
        <div class="row pt-5">
            {{$vendas->links()}}
        </div>
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