<div>

    <div class="form-group mb-2">
        <label for="cep">CEP</label>
        <div class="input-group">
            <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-city"></i></div>
            <input type="text" wire:model="cep" wire:change="buscarCep($event.target.value)" name="cep" class="form-control" id="cep" placeholder="00000-000">
        </div>
    </div>
        <div class="form-group mb-2">
            <label for="cidadeEstado">Cidade - Estado</label>
            <div class="input-group">
                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-city"></i></i></div>
                <input wire:model="cidadeEstado" type="text" name="cidadeEstado" class="form-control" id="cidadeEstado" placeholder="Nome da cidade e estado" readonly>
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="logradouro">Logradouro</label>
            <div class="input-group">
                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-street-view"></i></i></div>
                <input type="text" wire:model="logradouro" name="logradouro" class="form-control" id="logradouro" placeholder="Informe o endereço">
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="logradouro">Bairro</label>
            <div class="input-group">
                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-street-view"></i></i></div>
                <input type="text" wire:model="bairro" name="bairro" class="form-control" id="bairro" placeholder="Informe o bairro">
            </div>
        </div>
        <div class="form-group mb-1">
            <label for="exampleInputpwd2">Número</label>
            <div class="input-group">
                <div class="input-group-addon d-flex justify-content-center align-items-center"><i class="fas fa-house-user"></i></div>
                <input type="number" wire:model="numero" name="numero" class="form-control" id="exampleInputpwd2" placeholder="Informe o número da casa">
            </div>
        </div>

        <input type="hidden" wire:model="cidade" name="cidade" class="form-control">
        <input type="hidden" wire:model="estado" name="estado" class="form-control">

</div>
