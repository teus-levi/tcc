<div>
    <div class="form-floating mb-3 col-md-6 col-lg-4">
        <input wire:model="cep" wire:change="buscarCep($event.target.value)" class="form-control" type="text" id="cep" name="cep" placeholder=" " autofocus />
        <label for="cep">CEP</label>
    </div>
    <div class="form-floating mb-3 col-md-8">
        <input wire:model="cidadeEstado" class="form-control" type="text" id="cidadeEstado" name="cidadeEstado" placeholder=" " readonly />
        <label for="cidadeEstado">Cidade - Estado</label>
    </div>
    <div class="form-floating mb-3 col-md-8">
        <input wire:model="logradouro" class="form-control" type="text" id="logradouro" name="logradouro" placeholder=" " autofocus />
        <label for="logradouro">Logradouro</label>
    </div>
    <div class="form-floating mb-3 col-md-4">
        <input wire:model="bairro" class="form-control" type="text" id="bairro" placeholder=" " name="bairro" autofocus />
        <label for="bairro">Bairro</label>
    </div>
    <div class="form-floating mb-3 col-md-4">
        <input wire:model="numero" class="form-control" type="number" name="numero" id="numero" placeholder=" " autofocus />
        <label for="numero">Número</label>
    </div>
</div>
