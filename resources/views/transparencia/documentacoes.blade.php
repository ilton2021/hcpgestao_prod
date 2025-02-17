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

        <div class="row">
            <div class="col-md-12 text-center">
                @if (Auth::user()->id == 1)
                    <a class="btn btn-dark btn-sm m-2" href="{{ route('cadastroDocumentacoes', $unidade->id) }}">
                        <b>Cadastro</b> <i class="fas fa-check"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="row" style="margin-top: 10px;">
            @foreach($documentacoes as $documento)
                <div class="col col-lg-4" style="margin-bottom: 20px;">
                    <a href="{{ asset('storage') }}/{{ $documento->caminho }}" target="_blank">
                        <div class="card" style="height:250px; width:auto;">
                            <center><img src="{{ asset('img/pdf.png') }}" style="height:80px; width: 80px;" id="" alt=""></center>
                            <div class="card-title border-top">
                                <p style="text-align: center; font-weight: bold;">{{ $documento->nome }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
@endsection