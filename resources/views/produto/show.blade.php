@extends('produto.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Produto nº {{ $produto->id }}</h2>
        </div>
        <div class="col-lg-12 text-right" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-primary" href="{{ route('produto.index') }}"> Voltar</a>
        </div>
    </div>

   <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Produto:</strong>
                {{ $produto->nome }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Descrição:</strong>
                {{ $produto->descricao }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>SKU:</strong>
                {{ $produto->SKU }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Preço:</strong>
                R$ {{ number_format($produto->preco, 2, ',', '.') }}
            </div>
        </div>
    </div>
@endsection