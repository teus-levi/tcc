@extends('layout')

@section('titulo')
    Relatório - Estoque
@endsection

@section('conteudo')
<h2 style="margin-left: 0%;" class="text-center mb-3">Relatório de Produtos Vencidos</h2>

<div class="container">
    <div class="row gx-3">
        <div class="col-12">
            <form method="POST" class="row mb-3" target="_blank" action="/relatorio/produtos">
                @csrf
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="status">
                            <option value="1" {{$filtros['status']  == 1 ? 'selected' : ''}}>Ativo</option>
                            <option value="2" {{$filtros['status'] == 2 ? 'selected' : ''}}>Inativo</option>
                            <option value="3" {{$filtros['status'] == 3 ? 'selected' : ''}}>Independente</option>
                        </select>
                        <label>Status Produto</label>
                    </div>
                </div>
                <div class="col d-flex align-items-center justify-content-end">
                    <button type="submit"  class="btn btn-primary w-50 h-75">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
