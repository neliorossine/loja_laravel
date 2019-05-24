@extends('pedido.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Lista de Pedidos</h2>
        </div>
        <div class="col-lg-12 text-left" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-success " href="{{ route('pedido.create') }}"> Novo Pedido</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    @if(sizeof($pedidos) > 0)
        <table class="table table-bordered">
            <tr>
                <th>Nº</th>
                <th>Data</th>
                <th>Produtos</th>
                <th>Total (R$)</th>
                <th width="280px">Ações</th>
            </tr>
            
            @foreach ($pedidos as $pedido)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ \Carbon\Carbon::parse($pedido->data)->format('d/m/Y') }}</td>
                    <td>{{ $pedido->produtos }}</td>
                    <td>R$ {{ number_format($pedido->total, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('pedido.destroy',$pedido->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('pedido.show',$pedido->id) }}">Ver</a>
                            <a class="btn btn-primary @if(!$pedido->produtos) disabled @endif"  href="{{ route('pedido.edit',$pedido->id) }}">Editar</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="alert alert-alert">Nenhum pedido encontrado!</div>
    @endif

    {!! $pedidos->links() !!}

@endsection