@extends('layout')

@section('titulo')
    BabyOn - Lista de Produtos
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center mb-3">Produtos</h2>

<div class="container">
    <div class="row gx-3">
        <div class="col-12">
            <form method="POST" class="row mb-3" action="/filtrarProdutos">
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
                            <option value="3" {{$filtros['ordenacao'] == 3 ? 'selected' : ''}}>Menor quantidade primeiro</option>
                        </select>
                        <label>Ordenação</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="classificacao">
                            <option value="1" {{1  == 1 ? 'selected' : ''}}>Ativo</option>
                            <option value="2" {{1 == 2 ? 'selected' : ''}}>Inativos</option>
                            <option value="3" {{1 == 2 ? 'selected' : ''}}>Independente</option>
                        </select>
                        <label>Classificação</label>
                    </div>
                </div>
                @if(isset($filtros['pesquisa']))
                <div class="col-12 col-md-6">
                    <div class="input-group input-group">
                        <input type="text" value="{{$filtros['pesquisa']}}" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do produto">
                    </div>
                </div>
                @else
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <div class="input-group input-group ">
                        <input type="text" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do produto">
                    </div>
                </div>
                @endif
                <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary w-25 ">Filtrar</button>
                </div>
            </form>
        </div>
        </div>
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
                                        <button class="btn btn-success"> <i class="fa-solid fa-plus fa-xs"></i></button>
                                    </th>
                                </form>
                            @else
                                <th>
                                <form action="/listarEstoque/{{ $item->id }}" method="GET">
                                    @csrf
                                    <button class="btn btn-warning mb-2"> <i class="fas fa-list fa-xs"></i></button>
                                </form>
                                    <form action="/registrarEstoque/{{ $item->id }}" method="post">
                                        @csrf
                                        <button class="btn btn-success">
                                            <i class="fa-solid fa-plus fa-xs"></i>
                                        </button>
                                    </form>
                                </th>
                            @endif
                            <th>
                                    <form action="/editarProduto/{{ $item->id }}" method="POST">
                                        @csrf
                                        <button class="btn btn-warning mb-2"> <i class="fa-solid fa-pen-to-square fa-xs"></i></button>
                                    </form>
                                    <form  class="deleteAlert" action="/removerProduto/{{ $item->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"> <i class="fas fa-times fa-xs"></i></button>
                                    </form>
                            </th>
                    </tr>
                @endforeach

            </tbody>
        </thead>
    </table>
    @if (isset($filtros))
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$produtos->appends($filtros)->links()}}
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$produtos->links()}}
            </div>
        </div>
    @endif

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
