@extends('layout')

@section('titulo')
    BabyOn - Ediçao de Perfil
@endsection
@section('conteudo')
<main class="flex-fill">
    <div class="container">
        <h1 class="mt-4">Minha conta</h1>
        <div class="row gx-3">
            <div class="col-4">
                <div class="list-group">
                    <a href="{{route('editarPerfil')}}" class="list-group-item list-group-item-action">
                        <i class="bi-person fs-6"></i> Perfil
                    </a>
                    <a href="{{route('editarEndereco')}}" class="list-group-item list-group-item-action">
                        <i class="bi-house-door fs-6"></i> Endereço
                    </a>
                    <a href="{{route('listarPedidos')}}" class="list-group-item list-group-item-action bg-primary text-light">
                        <i class="bi-truck fs-6"></i> Pedidos
                    </a>
                    <a href="{{route('editarSenha')}}" class="list-group-item list-group-item-action">
                        <i class="bi-lock fs-6"></i> Alterar Senha
                    </a>
                    <a href="/sair" class="list-group-item list-group-item-action">
                        <i class="bi-door-open fs-6"></i> Sair
                    </a>
                </div>
            </div>
            <!---->
            
            <div class="col-8">
                <form method="POST" class="row mb-3" action="/filtrarPedidos">
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
                    <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary w-25 ">Filtrar</button>
                    </div>
                </form>
                @if (isset($pedidos))
                    <?php $control = 0; ?>
                    @foreach ($pedidos as $item)
                        @if ($control != $item->id)
                        
                    
                            <div class="accordion">
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#{{$item->id}}">
                                            <b>Pedido código #{{$item->id}}</b>
                                            <span class="mx-1">(realizado em {{$item->created_at->format('d/m/Y')}})</span>
                                        </button>
                                    </div>
                                    <div id="{{$item->id}}" class="accordion-collapse collapse" data-bs-parent="#divPedidos">
                                        <div class="accordion-body">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Produto</th>
                                                        <th class="text-end">Unit.</th>
                                                        <th class="text-center">Qtde.</th>
                                                        <th class="text-end">Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total = 0; ?>
                                                    @foreach ($itensPedidos as $produto)
        
                                                        @if ($produto->venda == $item->id)
                                                            <tr>
                                                                <td>{{$produto->nome}}</td>
                                                                <td class="text-end">R${{number_format(($produto->valorUnitario / 100), 2, ",", ".")}}</td>
                                                                <td class="text-center">{{$produto->quantidade}}</td>
                                                                <td class="text-end">R${{number_format(($produto->valorUnitario * $produto->quantidade) / 100, 2, ",", ".")}}</td>
                                                            </tr>
                                                            <?php $total += (($produto->valorUnitario * $produto->quantidade) / 100) ?>
                                                        @endif
                                                    
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-end" colspan="3">Valor Total:</th>
                                                        <td class="text-end">R${{number_format($total, 2, ",", ".")}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end" colspan="3">Forma de Pagamento:</th>
                                                        <td class="text-end">{{$item->modoRecebimento}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-end" colspan="5">
                                                        <button class="btn btn-outline-warning ">Ver detalhes</button>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $control = $item->id ?>
                        @endif
                    @endforeach
                    
                @else
                    <div>
                        Nenhum pedido para listar.
                    </div>
                @endif
                @if (isset($filtros))
                    <div class="row pt-5">
                        {{$pedidos->appends($filtros)->links()}}
                    </div>
                @else
                    <div class="row pt-5">
                        {{$pedidos->links()}}
                    </div>
                @endif
                
            </div>
            <!---->
        </div>
    </div>
</main>
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    $('.cpf').mask('000.000.000-00');
    $('.telefone').mask('(00) 00000-0000');
</script>
@endpush

@endsection