
<div>
    @if (!is_null($carrinho))
        <button wire:click="addProdutoCarrinho({{ $produto }})" class="btn btn-danger mt-2 d-block">
            Adicionar ao Carrinho
        </button>
    @else
        <div class="d-flex">
            <button wire:click="addProdutoCarrinho({{ $produto }})" class="btn btn btn-primary w-100">
                    Adicionar ao carrinho
            </button>
        </div>
    @endif

</div>


