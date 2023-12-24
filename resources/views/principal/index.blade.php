@extends('layout')

@section('titulo')
    BabyOn - Home
@endsection

@section('conteudo')
<h2 class="text-center m-4" style="margin: 0;">
  Produtos
</h2>
<!--
<div id="carouselExampleControls" class="carousel" data-bs-ride="carousel">
  <div class="carousel-inner">
      <div class="carousel-item active">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 1</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 2</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 3</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 4</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 5</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 6</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 7</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 8</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
      <div class="carousel-item">
          <div class="card">
              <div class="img-wrapper"><img src="imagens\anime" alt="..."> </div>
              <div class="card-body">
                  <h5 class="card-title">Card title 9</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                      card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
          </div>
      </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
  </button>
</div>

<h2>Cadastrado</h2>
-->
<main class="flex-fill">
    <div class="container">
        <div class="row">
            @csrf
            <form class="d-flex " action="/filtrarHome" method="GET">
                <div class="col-12 col-md-5">
                    <div class="justify-content-center justify-content-md-start mb-3 mb-md-0">
                        <div class="input-group input-group-sm">
                            @if(isset($procura))
                                <input type="text" name="pesquisa" class="form-control" value="{{$procura}}" placeholder="Digite aqui o que procura">
                            @else
                                <input type="text" name="pesquisa" class="form-control" placeholder="Digite aqui o que procura">
                            @endif
                            <button type="submit" class="btn btn-danger">Buscar</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-7">
                    <div class="d-flex flex-row-reverse justify-content-center justify-content-md-start">
                        <div class="d-inline-block">
                            <select name="ordenacao" class="form-select form-select-sm">
                                <option value="1" {{$filtros['ordenacao'] == 1 ? 'selected' : ''}}>Ordenar pelo nome</option>
                                <option value="2" {{$filtros['ordenacao'] == 2 ? 'selected' : ''}}>Ordenar pelo menor preço</option>
                                <option value="3" {{$filtros['ordenacao'] == 3 ? 'selected' : ''}}>Ordenar pelo maior preço</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
                    <!--
                    <nav class="d-inline-block me-3">
                        <ul class="pagination pagination-sm my-0">
                            <li class="page-item">
                                <a class="page-link" href="#">1</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">4</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">5</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">6</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <hr mt-3>
        
        <div class="row g-3">
            
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card text-center bg-light">
                    <a href="#" class="position-absolute end-0 p-2 text-danger">
                        <i class="bi bi-suit-heart" style="font-size: 24px; line-height: 24px;"></i>
                    </a>
                    <a href="/produto.html">
                        <img src="imagens\anime" class="card-img-top">
                    </a>
                    <div class="card-header">
                        R$ 4,50
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Banana Prata</h5>
                        <p class="card-text">
                            Banana prata da melhor qualidade possível, direto do produtor rural para a sua mesa.
                        </p>
                    </div>
                    <div class="card-footer">
                        <a href="carrinho.html" class="btn btn-danger mt-2 d-block">
                            Adicionar ao Carrinho
                        </a>
                        <small class="text-success">320,5kg em estoque</small>
                    </div>
                </div>
            </div>
        -->
        <!--
                foreach ($produtos as $produto)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                        <div class="card text-center bg-light">
                            <a href="#" class="position-absolute end-0 p-2 text-danger">
                                <i class="bi bi-suit-heart" style="font-size: 24px; line-height: 24px;"></i>
                            </a>
                            <a href="/detalheProduto/{$produto->id}}">
                                <img src="storage/{$produto->imagem}}" class="card-img-top">
                            </a>
                            <div class="card-header">
                                R$ {$produto->precoVendaAtual}},00 reais
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{produto->nome}}</h5>
                                <p class="card-text">
                                    {$produto->descricao}}
                                </p>
                            </div>
                            <div class="card-footer">
                                livewire('botao-carrinho-produto', ['produto' => $produto->id])
                                <small class="text-success">{$produto->quantidade}} em estoque</small>
                            </div>
                        </div>
                    </div>
                endforeach
        </div>
        
        <div class="row pt-5">
            {produtos->links()}}
        </div>

    </div>
-->
    </div>
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($produtos as $produto)
                    
                
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <a href="/detalheProduto/{{$produto->id}}">
                            <img class="card-img-top" src="storage/{{$produto->imagem}}" alt="..." />
                         </a>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{$produto->nome}}</h5>
                                <!-- Product price-->
                                R$
                                <span class="precoVendaAtual">
                                    {{$produto->precoVendaAtual}}
                                </span>
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                @livewire('botao-carrinho-produto', ['produto' => $produto->id, 'carrinho' => $carrinho])
                                <small class="text-success">{{$produto->quantidade}} em estoque</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @if(!isset($filtros))
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$produtos->links()}}
            </div>
        </div>
    @else
        <div class="d-flex justify-content-center mb-5">
            <div class="row pt-5">
                {{$produtos->appends($filtros)->links()}}
            </div>
        </div>
    @endif

            </div>
</main>
@endsection
@push('formatar_script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
      $('.precoVendaAtual').mask("#.##0,00", {reverse: true});
  </script>
@endpush
