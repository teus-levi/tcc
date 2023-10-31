<div class="flex-fill">
    <div class="container">
        <h1>Carrinho de Compras</h1>
        <ul class="list-group mb-3">
            @foreach (session('cart') as $id => $item)
                <li class="list-group-item py-3">
                    <div class="row g-3">
                        <div class="col-4 col-md-3 col-lg-2">
                            <a href="/detalheProduto/{{$item['id']}}">
                                <img src="/storage/{{$item['imagem']}}" class="img-thumbnail">
                            </a>
                        </div>
                        <div class="col-8 col-md-9 col-lg-7 col-xl-8 text-left align-self-center">
                            <h4>
                                <b><a href="#" class="text-decoration-none text-danger">
                                        {{$item['nome']}}</a></b>
                            </h4>
                            <h5>
                                Marca:
                            </h5>
                        </div>
                        <div
                            class="col-6 offset-6 col-sm-6 offset-sm-6 col-md-4 offset-md-8 col-lg-3 offset-lg-0 col-xl-2 align-self-center mt-3">
                            <div class="input-group">
                                <button wire:click="decrement({{$item['id']}})" class="btn btn-outline-dark btn-sm" type="button">
                                    <i class="bi-caret-down" style="font-size: 16px; line-height: 16px;"></i>
                                </button>
                                <input type="text" class="form-control text-center border-dark" value="{{$item['quantidade']}}">
                                <button wire:click="increment({{$item['id']}})" class="btn btn-outline-dark btn-sm" type="button">
                                    <i class="bi-caret-up" style="font-size: 16px; line-height: 16px;"></i>
                                </button>
                                <button wire:click="remove({{$item['id']}})" class="btn btn-outline-danger border-dark btn-sm" type="button">
                                    <i class="bi-trash" style="font-size: 16px; line-height: 16px;"></i>
                                </button>
                            </div>
                            <div class="text-end mt-2">
                                <small class="text-secondary">Valor Item: R$ <span class="preco">{{$item['preco']}}</span></small><br>
                                <span class="text-dark">Valor total: R$ <span class="preco">{{$item['preco'] * $item['quantidade']}}</span></span>
                                
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
            <li class="list-group-item py-3">
                <div class="text-end">
                    <h4 class="text-dark mb-3">
                        Valor Total: R$ <span class="preco">{{$total}}</span>
                    </h4>
                    <a href="/home" class="btn btn-outline-success btn-lg">
                        Continuar Comprando                            
                    </a>
                    <a href="/confirmarEndereco" class="btn btn-danger btn-lg ms-2 mt-xs-3">Fechar Compra</a>
                </div>
            </li>
        </ul>
    </div>
</div>
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $('.preco').mask("#.##0,00", {reverse: true});
  </script>
@endpush