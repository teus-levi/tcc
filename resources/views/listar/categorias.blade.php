@extends('layout')

@section('titulo')
    BabyOn - Listagem de Categorias
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Categorias</h2>
    
<div class="container">
    <div class="w-50 mx-auto">
    <div class="d-flex justify-content-end">
    <form action="/registrarCategorias" method="get">
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
                @foreach ($categorias as $item)
                    <tr>
                        <th>{{$item->id}}</th>
                        <th>{{$item->nome}}</th>
                        <th class="d-flex">
                            <div class="me-4">
                            <form action="/editarCategoria/{{ $item->id }}" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm mb-2"> <i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            </form>
                            </div>
                            <div>
                            <form  class="deleteAlert" action="/removerCategoria/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"> <i class="fas fa-trash"></i> Excluir</button>    
                            </form>
                            </div>
                        </th>
                        
                        
                    </tr>
                @endforeach
                
            </tbody>
        </thead>
    </table>
    <div class="d-flex justify-content-center mb-5">
        <div class="row pt-5">
            {{$categorias->links()}}
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
      text: "A categoria será deletada, e os produtos desta categoria não serão listados após essa operação. Deseja confirmar a exclusão?",
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