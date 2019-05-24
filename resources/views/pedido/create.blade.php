@extends('pedido.layout')

@push('scripts')
    <script src="{{ asset('/js/pedido.js')}}" ></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Novo Pedido</h2>
        </div>
        <div class="col-lg-12 text-right" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-primary" href="{{ route('pedido.index') }}"> Voltar</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Oops!</strong> Houve algum problema com os dados informados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pedido.store') }}" method="POST">
        @csrf


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
                <tr>
                    <td>
                        <select class="form-control" data-tipo="produto" name="venda[0][produto]">
                            <option value="0" disabled selected>Escolha o produto</option>
                            @foreach($produtos as $produto)
                                <option value="{{$produto->id}}" data-price="{{$produto->preco}}">{{$produto->nome}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                         <input disabled type="text" name="venda[0][valor]" class="form-control" data-tipo="valor" placeholder="Valor">
                    </td>
                    <td>     
                        <input type="number" name="venda[0][qtde]" class="form-control" data-tipo="qtde" placeholder="Quantidade" value='1'>
                    </td>
                    <td>     
                       <input type="button" name="venda[0][remove]" value="remover" class="btn btn-default" data-tipo="remove" onclick="btnRemoveItem( $(this).closest('tr'))"></input>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a href="#" id="btnNewItem" class="btn btn-default">Inserir Item</a>
            </div>
            <div class="form-group float-right" style="padding-right:10px">
                <label class="font-weight-bold">Total: R$ <span id="total">0.00</span> </label>
                <input type="hidden" name="total" value="0" />
                
            </div>

        </div>

         <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Finalizar Pedido</button>
         </div>

    </form>
@endsection