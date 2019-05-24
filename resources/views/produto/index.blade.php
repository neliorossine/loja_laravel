@extends('produto.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Lista de Produtos</h2>
        </div>
        <div class="col-lg-12 text-left" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-success " href="{{ route('produto.create') }}"> Novo Produto</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    @if(sizeof($produtos) > 0)
        <table class="table table-bordered">
            <tr>
                <th>Nº</th>
                <th>Ref.</th>
                <th>Produto</th>
                <th>Preço</th>
                <th width="280px">Ações</th>
            </tr>
            @foreach ($produtos as $produto)
                <tr>
                    <td>{{ $produto->id }}</td>
                    <td>{{ $produto->SKU }}</td>
                    <td>{{ $produto->nome }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('produto.destroy',$produto->id) }}" method="POST">

                            <a class="btn btn-info" href="{{ route('produto.show',$produto->id) }}">Ver</a>
                            <a class="btn btn-primary" href="{{ route('produto.edit',$produto->id) }}">Editar</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Remover</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <div class="alert alert-alert">Nenhum produto encontrado!</div>
    @endif

    {!! $produtos->links() !!}

@endsection