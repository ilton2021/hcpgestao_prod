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
        <form action="{{ route('updateDocumentacao', array($unidade->id, $documentacao[0]->id)) }}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-control" style="color:black">
                <div class="form-row mt-3">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-3 mr-4">
                            <label><strong>Nome:</strong></label>
                        </div>
                        <div class="col-md-8 mr-2">
                            <input class="form-control form-control-sm" type="text" id="nome" name="nome" value="<?php echo $documentacao[0]->nome; ?>" required />
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-3 mr-4">
                            <label><strong>Arquivo:</strong></label>
                        </div>
                        <div class="col-md-8 mr-2">
                            <input type="text" class="form-control" name="" id="" value="<?php echo $documentacao[0]->arquivo; ?>" readonly>
                            <input type="file" class="form-control" name="arquivo" id="arquivo">
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-12 mr-2">
                            <center>
                                <a href="{{ route('cadastroDocumentacoes', $unidade->id) }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
                                <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Alterar" id="Salvar" name="Salvar" />
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </form>
@endsection