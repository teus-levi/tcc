@extends('layout')

@section('titulo')
    BabyOn - Lista de Estoque
@endsection


@section('conteudo')


    <h2 style="margin-left: 0%;" class="text-center">Estoque</h2>
    <p class="text-muted text-center mb-5">Estoque do produto: {{$est[0]->n_produto}}</p>



<div class="container">
    <div class="d-flex justify-content-end">
    <form action="/registrarEstoque/{{$est[0]->produto}}" method="POST">
        @csrf
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
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
                <th>Lote</th>
                <th>Validade</th>
                <th>Ação</th>
            </tr>
            <tbody>
                @foreach ($est as $item)
                    <tr>
                        <th>{{$item->id}}</th>
                        <th>{{$item->n_produto}}</th>
                        <th>{{$item->quantidade}}</th>
                        <th class="precoCompra">{{$item->precoCompra}}</th>
                        <th>{{$item->lote}}</th>
                        <th>{{$item->validade}}</th>
                        <th>
                        <form action="/editarEstoque/{{ $item->id }}" method="GET">
                            @csrf
                            <button class="btn btn-warning btn-sm mb-2"> <i class="fa-solid fa-pen-to-square"></i></button>
                        </form>
                        @if($item->deleted_at == NULL)
                            <form  class="deleteAlert" action="/removerEstoque/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"> <i class="fa-solid fa-toggle-on fa-xs"></i></button>
                            </form>
                        @else
                            <form  class="activeAlert" action="/ativarEstoque/{{ $item->id }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm"> <i class="fa-solid fa-toggle-off fa-xs"></i></button>
                            </form>
                        @endif
                        </th>
                    </tr>
                @endforeach

            </tbody>
        </thead>
    </table>
</div>
@endsection
@push('scripts')

<script>
      $('.deleteAlert').on('submit', function(e){
    e.preventDefault();
    swal({
      title: "Atenção!",
      text: "O estoque será desativado, deseja confirmar?",
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
      text: "O estoque será ativado, deseja confirmar?",
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
      $('.precoCompra').mask("#.##0,00", {reverse: true});
  </script>
@endpush
