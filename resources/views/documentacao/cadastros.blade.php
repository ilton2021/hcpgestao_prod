@extends('navbar.default-navbar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <h5 style="font-size: 18px;">DOCUMENTAÇÕES:</h5>
            </div>
        </div><br />
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="d-flex flex-column">
            <div>
                <a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button"
                    data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                    Documentações: <i class="fas fa-check-circle"></i>
                </a>
            </div>
        </div>

        <div class="row p-4">
            <div class="col-md-12 text-center">
                <a class="btn btn-warning btn-sm m-2" href="{{ route('documentacoes', $unidade->id) }}">
                    <b>Voltar</b> <i class="fas fa-check"></i>
                </a>
                <a class="btn btn-info btn-sm m-2" href="{{ route('novoDocumentacao', $unidade->id) }}">
                    <b>Novo</b> <i class="fas fa-check"></i>
                </a>
            </div>
        </div>

        <table>
            <div class="card-header">
                <table class="table table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Arquivo</th>
                            <th>Alterar</th>
                            <th>Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentacoes as $documentacao)
                        <tr>
                            <th class="text-truncate" style="font-size:16px;max-width:100px">{{$documentacao->nome}}</th>
                            <th class="text-truncate" style="font-size:16px;max-width:100px">{{$documentacao->arquivo}}</th>
                            <th style="font-size:18px;max-width:5px;"><a href="{{ route('alterarDocumentacao', array($unidade->id, $documentacao->id)) }}"><button class="btn btn-warning"><i class="bi bi-pencil-square"></button></a></th>
                            <th style="font-size:18px;max-width:10px;"><a href="{{ route('deleteDocumentacao', array($unidade->id, $documentacao->id)) }}"><button class="btn btn-danger"><i class="bi bi-trash3"></button></a></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </table>
@endsection