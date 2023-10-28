@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Marcas
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Marcas</h2>
    
<div class="container">
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
                            <form action="/editarMarca/{{ $item->id }}" method="POST">
                                @csrf
                                <button class="btn btn-warning btn-sm mb-2"> <i class="fa-solid fa-pen-to-square"></i> Editar</button>
                            </form>
                            </div>
                            <div>
                            <form  class="deleteAlert" action="/removerMarca/{{ $item->id }}" method="POST">
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
    <div class="row pt-5">
        {{$marcas->links()}}
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
      text: "A marca será deletada, e os produtos desta marca não serão listados após essa operação. Deseja confirmar a exclusão?",
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