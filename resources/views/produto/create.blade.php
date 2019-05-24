@extends('produto.layout')

@push('scripts')
    <script src="{{ asset('/js/produto.js')}}" ></script>
@endpush

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h2 class="text-center">Novo Produto</h2>
        </div>
        <div class="col-lg-12 text-right" style="margin-top:10px;margin-bottom: 10px;">
            <a class="btn btn-primary" href="{{ route('produto.index') }}"> Voltar</a>
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

     <form action="{{ route('produto.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nome:</strong>
                    <input type="text" name="nome" class="form-control" placeholder="Nome">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Descrição:</strong>
                    <textarea class="form-control" style="height:150px" name="descricao" placeholder="Descrição"></textarea>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>SKU:</strong>
                    <input type="text" name="SKU" class="form-control" placeholder="Ex: ABC123" value=''>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Preço:</strong>
                    <input type="text" name="preco" class="form-control currency" placeholder="Ex: 100,00">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
            </div>
        </div>

    </form>
@endsection