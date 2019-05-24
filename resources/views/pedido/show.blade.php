@extends('pedido.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Pedido nº {{ $pedido->id }}</h2>
        </div>
        <div class="col-lg-12 text-right" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-primary" href="{{ route('pedido.index') }}"> Voltar</a>
        </div>
    </div>

    <div class="form-group">
        <label class="font-weight-bold">Data: </label> <span> {{ \Carbon\Carbon::parse($pedido->data)->format('d/m/Y') }}</span>
        <br/>
        <label class="font-weight-bold">Total: </label> <span> R$ {{ number_format($pedido->total, 2, ',', '.') }}</span>            
    </div>

    <div class="form-group">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Valor Unitario (R$)</th>
                    <th>Quantidade</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($itens as $item)
                    <tr>
                        <td>
                            <labe>{{ $item->nome }}</labe>
                        </td>
                        <td>
                             <labe>R$ {{ number_format($item->preco, 2, ',', '.') }}</labe>
                        </td>
                         <td>
                             <labe>{{ $item->quantidade }}</labe>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
@endsection