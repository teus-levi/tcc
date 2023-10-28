@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Produtos
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Produtos</h2>
    
<div class="container">
    <div class="d-flex justify-content-end">
    <form action="/registrarProdutos" method="get">
        <button class="btn btn-success">
            <i class="fa-solid fa-plus"></i>
        </button>
    </form>
    </div>
    <hr>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Marca</th>
                <th>Categoria</th>
                <th>Quantidade</th>
                <th>Estoque</th>
                <th>Ação</th>
            </tr>
            <tbody>
                @foreach ($produtos as $item)
                    <tr>
                        <th>{{$item->id}}</th>
                        <th>
                            <div style="width: 7em; height: 7em;" class="d-block">
                            <img src="storage/{{$item->imagem}}" class="img-fluid" alt="...">
                            </div>
                        </th>
                        <th>{{$item->nome}}</th>
                        <th class="precoVendaAtual">{{$item->precoVendaAtual}}</th>
                        <th>{{$item->n_marca}}</th>
                        <th>{{$item->n_categoria}}</th>
                        <th>
                            @if(!is_null($item->quantidade))
                                {{$item->quantidade}}
                            @else
                                0
                            @endif
                        </th>
                            @if($item->quantidade == 0 || is_null($item->quantidade))
                                <form action="/registrarEstoque/{{ $item->id }}" method="POST">
                                    @csrf
                                    <th>
                                        <form action="/registrarEstoque/{{$item->id}}" method="post">
                                            <button class="btn btn-success btn-sm"> <i class="fas fa-user-plus"></i> Adicionar</button>
                                         </form>
                                    </th>
                                </form>
                            @else
                                <form action="/listarEstoque/{{ $item->id }}" method="GET">
                                    @csrf
                                    <th>
                                    <button class="btn btn-warning btn-sm"> <i class="fa-solid fa-pen-to-square"></i>Listar</button>
                                    </th>
                                </form>
                            @endif
                            <th>
                            <form action="/editarProduto/{{ $item->id }}" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm mb-2"> <i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            </form>
                            <form  class="deleteAlert" action="/removerProduto/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> Excluir</button>    
                            </form>
                            </th>
                    </tr>
                @endforeach
                
            </tbody>
        </thead>
    </table>
    <div class="row pt-5">
        {{$produtos->links()}}
    </div>
</div>
@endsection
@push('scripts')

<script>
      $('.deleteAlert').on('submit', function(e){
    e.preventDefault();
    swal({
      title: "Atenção!",
      text: "O produto será deletado, juntamente com o estoque do mesmo. Deseja confirmar a exclusão?",
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