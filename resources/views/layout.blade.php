<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="imagens\logo.png">
    <title>@yield('titulo')</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <script src="https://kit.fontawesome.com/80f45105ae.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" integrity="sha512-gOQQLjHRpD3/SEOtalVq50iDn4opLVup2TF8c4QPI3/NmUPNZOk2FG0ihi8oCU/qYEsw4P6nuEZT2lAG0UNYaw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="{{ asset ('css/home.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @stack('dropify_style')
    <!--LiveWere (procura automática)-->
    @livewireStyles
</head>
<body>
  <!-- Modal -->

    <nav class="navbar navbar-expand-lg bg-light-color d-flex">
        <div class="container-fluid">
          <a class="navbar-brand logo" href="#">BabyOn</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="{{ route('home')}}">Home</a>
              </li>
              @auth
              <li class="nav-item">
                <a class="nav-link" href="{{route('editarPerfil')}}">Perfil</a>
              </li>
              @endauth
              @can('administrador')
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Gerenciar
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ route('listarProdutos')}}">Produtos</a></li>
                    <li><a class="dropdown-item" href="{{ route('listarMarcas')}}">Marcas</a></li>
                    <li><a class="dropdown-item" href="{{ route('listarCategorias')}}">Categorias</a></li>
                    <li><a class="dropdown-item" href="{{ route('listarVendas')}}">Vendas</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('registrarAdministradores')}}">Administradores</a></li>
                  </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Relatórios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <li><a class="dropdown-item" href="{{ route('relatorioEstoque')}}">Estoque</a></li>
                        </li>
                        <li>
                            <li><a class="dropdown-item" href="{{ route('relatorioVendas')}}">Vendas</a></li>

                        </li>
                        <li>
                            <li><a class="dropdown-item" href="{{ route('relatorioProdutosVencidos')}}">Produtos vencidos</a></li>

                        </li>
                    </ul>
                </li>
              @endcan
              @auth
                <li class="nav-item">
                  <a class="nav-link" href="/sair">Sair</a>
                </li>
              @endauth
              <!-- Visitante  = guest -->
              @guest
                <li class="nav-item">
                  <a class="nav-link" href="/">Entrar</a>
                </li>
              @endguest
            </ul>
            <!-- carrinho-->
            @livewire('carrinho')
            <!-- -->
            <!-- carrinho-->

            <!-- livewire('notificacoes') -->
            <!-- -->
          </div>
        </div>
      </nav>



    </div>

    @yield('conteudo')
    @livewireScripts
    @yield('delete_script')
</body>
<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
  <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js" integrity="sha512-7VTiy9AhpazBeKQAlhaLRUk+kAMAb8oczljuyJHPsVPWox/QIXDFOnT9DUk1UC8EbnHKRdQowT7sOBe7LAjajQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
  @if(session('mensagem'))
  <script>
    swal("Finalizado!", "{!!session('mensagem')!!}", "success",{
      button: "ok"
    });
  </script>
  @elseif(session('erro'))
    <script>
      swal("Ops!", "{!!session('erro')!!}", "error",{
        button: "ok"
      });
    </script>
  @endif
<script>
$( '.single-select-field' ).select2( {
    theme: "bootstrap-5",
    width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
    placeholder: $( this ).data( 'placeholder' ),
} );
</script>
<script>
  window.addEventListener('swal:modal', event => {
    swal("Ops!", "Esse cep não foi encontrado, tente novamente.", "error",{
        button: "ok"
    });
  });
</script>
@stack('dropify_script')
@stack('scripts')
@stack('formatar_script')
@stack('validacao')
  </html>
