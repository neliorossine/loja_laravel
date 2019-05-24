@extends('pedido.layout')

@push('scripts')
    <script src="{{ asset('/js/pedido.js')}}" ></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Editar Pedido nº {{ $pedido->id }}</h2>
        </div>
        <div class="col-lg-12 text-right" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-primary" href="{{ route('pedido.index') }}"> Voltar</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Opa!</strong> Houve algum problema com os dados informados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pedido.update',$pedido->id) }}" method="POST">
        @csrf
        @method('PUT')


        <div class="form-group">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Produto</th>
                    <th>Valor Unitario (R$)</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($itens as $i => $item)
                    <tr>
                        <td>
                            <select class="form-control" data-tipo="produto" name="venda[{{ $i }}][produto]">
                                <option value="0" disabled selected>Escolha o produto</option>
                                @foreach($produtos as $produto)
                                    <option value="{{$produto->id}}" {{ $item->id_produto == $produto->id ? 'selected' : '' }} data-price="{{$produto->preco}}">{{$produto->nome}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                             <input readonly type="text" name="venda[{{ $i }}][valor]" class="form-control currency" data-tipo="valor" placeholder="Valor" value="{{ $item->preco }}">
                        </td>
                        <td>     
                            <input type="number" name="venda[{{ $i }}][qtde]" class="form-control" data-tipo="qtde" placeholder="Quantidade" value="{{ $item->quantidade }}">
                        </td>
                        <td>     
                           <input type="button" name="venda[{{ $i }}][remove]" value="remover" class="btn btn-default" data-tipo="remove" onclick="btnRemoveItem( $(this).closest('tr'))"></input>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="form-group">
                <a href="#" id="btnNewItem" class="btn btn-default">+ Inserir Item</a>
            </div>
            <div class="form-group float-right" style="padding-right:10px">
                <label class="font-weight-bold">Total: R$ <span id="total">0.00</span> </label>
                <input type="hidden" name="total" value="0" />
                
            </div>

        </div>

         <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Atualizar Pedido</button>
         </div>

    </form>
@endsection