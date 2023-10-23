@extends('layout')

@section('titulo')
    BabyOn - Cadastro de Produtos
@endsection


@section('conteudo')

    
    <div id="product-template" class="pt-5 pt-sm-10 pb-0 flex-fill">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-6">
                    
                    <img class="img-thumbnail" src="/storage/{{$produto[0]->imagem}}" alt="Bag Series 1">
                </div>
                <div class="col-lg-6">
                    <div id="product-content">
                        
                            <p class="product-vendor text-muted my-1 text-uppercase">
                                BabyOn
                            </p>
                        
                        <h1 class="title mb-1 fw-bold">
                            {{$produto[0]->nome}}
                        </h1>
                        <p class="product-price fs-4 mb-2 fw-bold">
                            
                                <span class="product-price-final">
                                    R${{$produto[0]->precoVendaAtual}}
                                </span>
                            
                            
                            
                        </p>
     
    <div class="form-wrapper mb-4 rounded bg-light p-6">
        <form method="post" action="/cart/add" id="product_form_6138661372066" accept-charset="UTF-8" class="shopify-product-form" enctype="multipart/form-data" onsubmit="onSubmitAtcForm(this, event)"><input type="hidden" name="form_type" value="product"><input type="hidden" name="utf8" value="✓">
            <input type="hidden" name="id" value="37815857545378">
            
            

                    
                        <div class="mb-3">
                            <label class="input-group-text" for="product-option-color">
                                Marca: {{$produto[0]->n_marca}}
                            </label>
                        </div>
                    
                        <div class="mb-3">
                            <label class="input-group-text" for="product-option-size">
                                Estoque: {{$produto[0]->quantidade}} unidades
                            </label>
                        </div>
                    
            
    
            <div class="d-flex">
                <input class="form-control me-3" type="number" name="quantity" value="1" aria-label="Quantity" style="max-width: 90px;">
                <button class="btn-atc btn btn-primary w-100" type="submit" name="add" data-text-add-to-cart="Add to cart">
                    
                        Adicionar ao carrinho
                    
                </button>
            </div>
    
            
                <button class="btn-buy btn btn-outline-secondary w-100 mt-4" type="button" onclick="onClickBuyBtn(this, event)">
                    Comprar
                </button>
            
    
        <input type="hidden" name="product-id" value="6138661372066"></form>
    </div>
            <div id="product-accordion" class="accordion mb-5">
        
            
                <div class="accordion-item">
                    <h3 id="product-blocks-heading-58913963-afac-40f1-aaef-9a8b2084dc99" class="accordion-header mb-0">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#product-blocks-collapse-58913963-afac-40f1-aaef-9a8b2084dc99" aria-expanded="false" aria-controls="product-blocks-collapse-58913963-afac-40f1-aaef-9a8b2084dc99">
                            Detalhes
                        </button>
                    </h3>
                    <div id="product-blocks-collapse-58913963-afac-40f1-aaef-9a8b2084dc99" class="accordion-collapse collapse" aria-labelledby="product-blocks-heading-58913963-afac-40f1-aaef-9a8b2084dc99" style="">
                        <div class="accordion-body">
                            
                                <div class="product-description rte">
                                    <p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac leo eget dolor ultricies feugiat. In facilisis urna massa, nec ultricies est mollis eget. Ut tempus ligula a sem ultrices, vel fringilla ipsum cursus. </span></p>
                                    <p><span>Ut sit amet metus id ante euismod tincidunt. Donec quis orci non enim congue rutrum. </span><span>Cras mollis ultrices orci sed tincidunt. Aliquam rhoncus a ex non pharetra.&nbsp;<meta charset="utf-8">Cras consectetur ultricies augue non porttitor.</span></p>
                                    <h6>Features</h6>
                                    <ul>
                                        <li>
                                        <meta charset="utf-8"> <span>Maecenas quam urna, bibendum sit amet consequat vitae</span>
                                        </li>
                                        <li>
                                        <meta charset="utf-8"> <span data-mce-fragment="1">Suspendisse imperdiet tellus quis odio ultrices ultrices</span><br>
                                        </li>
                                        <li>
                                        <meta charset="utf-8"> <span>Vivamus faucibus finibus tellus eget elementum.</span>
                                        </li>
                                        <li>
                                        <meta charset="utf-8"> <span>Vivamus id lobortis massa, in suscipit risus.</span>
                                        </li>
                                        <li>
                                        <meta charset="utf-8"> <span>Ut sit amet metus id ante euismod tincidunt.&nbsp;&nbsp;</span>
                                        </li>
                                    </ul>
                                </div>
                            
                        </div>
                    </div>
                </div>
            
        
            
                <div class="accordion-item">
                    <h3 id="product-blocks-heading-9bcd0fdf-578a-47f6-bc90-d14ef3dbeaa5" class="accordion-header mb-0">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#product-blocks-collapse-9bcd0fdf-578a-47f6-bc90-d14ef3dbeaa5" aria-expanded="true" aria-controls="product-blocks-collapse-9bcd0fdf-578a-47f6-bc90-d14ef3dbeaa5">
                            Compras &amp; Retornos
                        </button>
                    </h3>
                    <div id="product-blocks-collapse-9bcd0fdf-578a-47f6-bc90-d14ef3dbeaa5" class="accordion-collapse collapse " aria-labelledby="product-blocks-heading-9bcd0fdf-578a-47f6-bc90-d14ef3dbeaa5">
                        <div class="accordion-body">
                            
                                <div class="description rte">
                                    <p>Feel free to create additional blocks like this for <strong>Shipping, Payments, etc </strong>through the Shopify Theme editor. Also, you may easily adjust their order by dragging and dropping.</p>
                                </div>
                            
                        </div>
                    </div>
                </div>
            
        
    </div>
    
                        
                            <div class="text-end">
                                
    
    <button class="btn-share btn btn-outline-primary btn-sm d-inline-flex align-items-center" type="button" data-text-share="Share" data-text-copy="Copy" data-text-copied="Copied!" data-share-title="
        Bag Series 1
     – KS BootShop" onclick="onLinkShare(this, event)">
        <svg xmlns="http://www.w3.org/2000/svg" class="me-3" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
        </svg>
        Compartilhar
    </button>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- listar produtos -->
    <div class="recommended-products featured-products position-relative overflow-hidden text-center pt-0 pb-11 mt-5 mb-0">
        <div class="container">
            <hr class="mb-5">
            <h2 class="title mb-4 h2" style="margin: 0;">
                Produtos Recomendados
            </h2>
                <div class="description rte mt-n3 mb-5 fs-5">
                    <p>Lista de produtos semelhantes</p>
                </div>
                <section class="py-5">
                    <div class="container px-4 px-lg-5 mt-5">
                        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                            @foreach ($produtosCategoria->slice(0, 7) as $produtoCategoria)
                                <div class="col mb-5">
                                    <div class="card h-100">
                                        <!-- Product image-->
                                        <img class="card-img-top" src="\storage\{{$produtoCategoria->imagem}}" alt="..." />
                                        <!-- Product details-->
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <!-- Product name-->
                                                <h5 class="fw-bolder">{{$produtoCategoria->nome}}</h5>
                                                <!-- Product price-->
                                                R$ {{$produtoCategoria->precoVendaAtual}}
                                            </div>
                                        </div>
                                        <!-- Product actions-->
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Ver produto</a></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
@endsection
