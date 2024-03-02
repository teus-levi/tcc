<div class="btn-group">
    <?php   
        $quantidade++;
    ?>
    
      <button type="button" class="btn dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-solid fa-message" style="color: #ffffff"></i>
        <span class="badge bg-danger"> {{$quantidade}} </span>
      </button>
      <ul class="dropdown-menu carrinho-scroll dropdown-cart">
        @if(!empty($noti))
        <li>
            <div class="drop-title">Você tem 4 novas mensagens</div>
        </li>
        <li>
            <div class="message-center">
                @foreach ($noti as $notif)
                    <a href="#">
                        <div class="user-img"> <img src="imagens/notificacao.png" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                        <div class="mail-contnet">
                            <h5 class="noti">Novo pedido!</h5>
                            <span class="mail-desc">{{$notif->descricao}}</span> <span class="time">9:30 AM</span> </div>
                    </a>
                @endforeach
                
            </div>
        </li>
        <li>
            <div class="d-flex justify-content-center">
                <a href="/notificacao">
                    <button class="m-3 btn btn-warning btn-sm">
                        <strong>See all notifications</strong> <i class="fa fa-angle-right"></i> 
                    </button>
                </a>
            </div>
        </li>
        @else
        <li>
            <p>
            Sem notificações novas no momento.
            </p>
        </li>
        @endif
      </ul>
</div>