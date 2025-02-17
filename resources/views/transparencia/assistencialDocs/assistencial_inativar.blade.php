@extends('navbar.default-navbar')
<style>
    input[type='file'] {
        display: none
    }

    .input-wrapper label {
        background-color: #3498db;
        border-radius: 5px;
        color: #fff;
        margin: 10px;
        padding: 6px 20px
    }

    .input-wrapper label:hover {
        background-color: #2980b9
    }
</style>

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
                        @if($assistenDoc[0]->status_ass_doc == 0)
                            Ativar documento de Relatório Anual de Gestão
                        @else
                            Inativar documento de Relatório Anual de Gestão
                        @endif 
                    </a>
				</div>
			</div>
            <form method="POST" action="{{ route('inativarRADOC', array($unidade->id, $assistenDoc[0]->id)) }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            @foreach($assistenDoc as $AD)
            <div class="form-control mt-3" style="color:black">
                <div class="form-row mt-3">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-2 mr-1">
                            <label><b>Título:</b></label>
                        </div>
                        <div class="col-md-4 mr-1">
                            <label>{{$AD->titulo}}</label>
                        </div>
                        <div class="col-md-3 mr-1">
                            <label><b>Ano:</b></label>
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
                              @if($assistenDoc[0]->status_ass_doc == 0)
                                <input type="submit" value="Ativar" id="Ativar" name="Ativar" class="btn btn-success btn-sm" />
                              @else
                                <input type="submit" value="Inativar" id="Inativar" name="Inativar" class="btn btn-primary btn-sm" />
                              @endif
						  </center>
						</div>
					</div>
			    </div>
                <div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
							  <center>
                                <input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
                                <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> 
                                <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> 
                                <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />            
							  </center>
							</div>
						</div>
					</div>
                </div>
            @endforeach
        </form>
    </div>
</div>
<script>
    var $input = document.getElementById('input-file'),
        $fileName = document.getElementById('file-name');

    $input.addEventListener('change', function() {
        $fileName.textContent = this.value;
    });
</script>
@endsection