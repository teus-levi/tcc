<div class="btn-group">
  <?php 
  $quantidade = 0;
  foreach(session('cart') as $id => $item){
    $quantidade += $item['quantidade'];
  }
  ?>
    <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-cart-plus" style="color: #ffffff;"></i>
      <span class="badge bg-danger"> {{$quantidade}} </span>
    </button>
    <ul class="dropdown-menu carrinho-scroll dropdown-cart">
      <li>
        <a class="dropdown-item" href="#">
          <div class="cart-content">
            <h5>Rounded Chair</h5>  
          </div>
          <div class="cart-img"><img src="\imagens\anime" /></div>
          <small>$153</small>
                      
        </a>
      </li>
      @if(session('cart'))
      @foreach (session('cart') as $id => $item)
      <li>
        <a class="dropdown-item" href="#">
          <div class="cart-content">
            <h5>{{$item['nome']}}</h5>  
          </div>
          <div class="cart-img"><img src="/storage/{{$item['imagem']}}" /></div>
          <small class="mr-5"> {{$item['quantidade']}} x R${{($item['quantidade'] * $item['preco'])}}</small>             
        </a>
      </li>
      @endforeach

      <div class="d-flex justify-content-center">
        <form action="#">
            <button class=" m-3 btn btn-warning btn-sm">Ver o carrinho</button>
        </form>
      </div>
      
      @else
      <div class="d-flex justify-content-center">
        <small>Sem produtos no carrinho</small>
      </div>
        @endif
        
    </ul>
  </div>



