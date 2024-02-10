@extends('layout')

@section('titulo')
    Relatório - Estoque
@endsection

@section('conteudo')
<h2 style="margin-left: 0%;" class="text-center mb-3">Produtos</h2>

<div class="container">
    <div class="row gx-3">
        <div class="col-12">
            <form method="POST" class="row mb-3" action="/filtrarProdutos">
                @csrf
                <div class="col-12 col-md-6 mb-3">
                    <div class="form-floating">

                        <select class="form-select" name="periodo">
                            <option value="30" {{$filtros['periodo'] == 30 ? 'selected' : ''}}>Últimos 30 dias</option>
                            <option value="60" {{$filtros['periodo']  == 60 ? 'selected' : ''}}>Últimos 60 dias</option>
                            <option value="90" {{$filtros['periodo']  == 90 ? 'selected' : ''}}>Últimos 90 dias</option>
                            <option value="180" {{$filtros['periodo']  == 180 ? 'selected' : ''}}>Últimos 180 dias</option>
                            <option value="360" {{$filtros['periodo']  == 360 ? 'selected' : ''}}>Últimos 360 dias</option>
                            <option value="9999" {{$filtros['periodo']  == 9999 ? 'selected' : ''}}>Todo o período</option>
                        </select>
                        <label>Período</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="ordenacao">
                            <option value="1" {{$filtros['ordenacao']  == 1 ? 'selected' : ''}}>Mais novos primeiro</option>
                            <option value="2" {{$filtros['ordenacao'] == 2 ? 'selected' : ''}}>Mais antigos primeiro</option>
                        </select>
                        <label>Ordenação</label>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="classificacao">
                            <option value="1" {{1  == 1 ? 'selected' : ''}}>Ativo</option>
                            <option value="2" {{1 == 2 ? 'selected' : ''}}>Inativos</option>
                        </select>
                        <label>Classificação</label>
                    </div>
                </div>
                @if(isset($filtros['pesquisa']))
                <div class="col-12 col-md-6">
                    <div class="input-group input-group">
                        <input type="text" value="{{$filtros['pesquisa']}}" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do produto">
                    </div>
                </div>
                @else
                <div class="col-12 col-md-6 d-flex align-items-center">
                    <div class="input-group input-group ">
                        <input type="text" name="pesquisa" class="form-control" placeholder="Digite aqui o nome do produto">
                    </div>
                </div>
                @endif
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary w-25 ">Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
