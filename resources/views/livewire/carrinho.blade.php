<div class="btn-group">
  <?php 
  $quantidade = 0;
    if(Session::has('cart')){
      foreach(session('cart') as $id => $item){
      $quantidade += $item['quantidade'];
      }
    }
  ?>
  
  
    <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-cart-plus" style="color: #ffffff;"></i>
      <span class="badge bg-danger"> {{$quantidade}} </span>
    </button>
    <ul class="dropdown-menu carrinho-scroll dropdown-cart">
      @if(session('cart'))
      @foreach (session('cart') as $id => $item)
      <li>
        <a class="dropdown-item" href="#">
          <div class="cart-content">
            <h5>{{$item['nome']}}</h5>  
          </div>
          <div class="cart-img"><img src="/storage/{{$item['imagem']}}" /></div>
          <small class="mr-5"> {{$item['quantidade']}} x R${{(number_format(($item['quantidade'] * $item['preco']) / 100, 2, ",", "."))}}</small>             
        </a>
      </li>
      @endforeach

      <div class="d-flex justify-content-center">
        <a href="/carrinho">
            <button class=" m-3 btn btn-warning btn-sm">Ver o carrinho</button>
        </a>
      </div>
      
      @else
      <li class="d-flex align-items-center justify-content-center"style="height: 50px;">
        <small class="">Sem produtos no carrinho</small>
      </li>
        @endif
        
    </ul>
  </div>



