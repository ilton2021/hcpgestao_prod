@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> 
    @endif
    <div class="row" style="margin-top: 25px; margin-left: auto; margin-right: auto; display: flex; justify-content: center">
		<div class="col-md-10 col-sm-4 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Exclusão documento de Relatório Anual de Gestão
                    </a>
				</div>
			</div>
            <form method="POST" action="{{ route('destroyRADOC', array($unidade->id, $assistenDoc[0]->id)) }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @foreach($assistenDoc as $AD)
                <div class="form-control mt-3" style="color:black">
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-3 mr-1">
                                <label><b>Título</b></label>
                            </div>
                            <div class="col-md-4 mr-1">
                                <label>{{$AD->titulo}}</label>
                            </div>
                            <div class="col-md-3 mr-1">
                                <label style="font-family:Arial black, Helvetica, sans-serif;">Ano:</label>
                            </div>
                            <div class="col-md-1 mr-1">
                                {{ $AD->ano }} 
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-12 mr-2">
                                <iframe class="embed-responsive-item" src="{{asset($AD->file_path)}}"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-12 mr-2">
                            <center>
                                <a href="{{route('cadastroRADOC', array($unidade->id, $AD->id))}}" class="btn btn-warning btn-sm" style="color:white;"><i class="fas fa-reply"></i> <b>Voltar</b></a>
                                <input type="submit" value="Excluir" id="Excluir" name="Excluir" class="btn btn-danger btn-sm" />
                            </center>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </form>
<script>
    var $input = document.getElementById('input-file'),
        $fileName = document.getElementById('file-name');

    $input.addEventListener('change', function() {
        $fileName.textContent = this.value;
    });
</script>

@endsection