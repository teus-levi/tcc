@extends('layout')

@section('titulo')
    BabyOn - Lista de Marcas
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Marcas</h2>

<div class="container">
    <div class="row gx-3">
        <div class="col-12">
            <form method="POST" class="row mb-3" action="/filtrarMarcas">
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
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="classificacao">
                            <option value="1" {{$filtros['classificacao']  == 1 ? 'selected' : ''}}>Ativo</option>
                            <option value="2" {{$filtros['classificacao'] == 2 ? 'selected' : ''}}>Inativos</option>
                            <option value="3" {{$filtros['classificacao'] == 3 ? 'selected' : ''}}>Independente</option>
                        </select>
                        <label>Classificação</label>
                    </div>
                </div>
                @if(isset($filtros['pesquisa']))
                <div class="col-12 col-md-6">
                    <div class="input-group input-group">
                        <input type="text" value="{{$filtros['pesquisa']}}" name="pesquisa" class="form-control" placeholder="Digite aqui o nome da marca">
                    </div>
                </div>
                @else
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <div class="input-group input-group ">
                        <input type="text" name="pesquisa" class="form-control" placeholder="Digite aqui o nome da marca">
                    </div>
                </div>
                @endif
                <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-primary w-25 ">Filtrar</button>
                </div>
            </form>
        </div>
        </div>
    <div class="w-50 mx-auto">
    <div class="d-flex justify-content-end">
    <form action="/registrarMarcas" method="get">
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
                <th class="col-6">Nome</th>
                <th>Ação</th>
            </tr>
            <tbody>
                @foreach ($marcas as $item)
                    <tr>
                        <th>{{$item->id}}</th>
                        <th>{{$item->nome}}</th>
                        <th class="d-flex">
                            <div class="me-4">
                                <a class="btn btn-warning btn-sm mb-2" data-bs-toggle="modal" href="#editar{{$item->id}}"> <i class="fa-solid fa-pen-to-square"></i></a>

                                <!-- MODAL -->
                                <div class="modal fade" id="editar{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Alterar marca</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                            <div class="modal-body ">
                                            <form action="/storeEditMarca/{{$item->id}}" method="POST">
                                                @csrf
                                                <p class=" d-flex justify-content-center">Informe o nome da marca:</p>
                                                <input type="text" name="nome" value="{{$item->nome}}" style="width: 100%;">
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
                            <div>
                            @if(is_null($item->deleted_at))
                                <form  class="deleteAlert" action="/removerMarca/{{ $item->id }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"> <i class="fa-solid fa-toggle-on fa-xs"></i></button>
                                </form>
                            @else
                                <form  class="activeAlert" action="/ativarMarca/{{ $item->id }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm"> <i class="fa-solid fa-toggle-off fa-xs"></i></button>
                                </form>
                            @endif
                            </div>
                        </th>


                    </tr>
                @endforeach

            </tbody>
        </thead>
    </table>
    <div class="d-flex justify-content-center mb-5">
        <div class="row pt-5">
            {{$marcas->links()}}
        </div>
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
      text: "A marca será desativada, e os produtos desta marca não serão listados após essa operação. Deseja confirmar?",
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

<script>
    $('.activeAlert').on('submit', function(e){
  e.preventDefault();
  swal({
    title: "Atenção!",
    text: "A marca será ativada, e os produtos desta marca serão listados após essa operação, caso não estejam desativados. Deseja confirmar?",
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
