@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DOCUMENTAÇÃO DE REGULARIDADE:</h3>
		</div>
	</div>
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
						Documentação de Regularidade: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
            <form method="post" action="{{ \Request::route('storeDR'), $unidade->id }}" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Título:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="text" id="name" name="name" value="{{ old('name') }}" required />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Tipo de Documento:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<select class="form-control form-control-sm" id="type_id" name="type_id" required>
								<?php $qtd = sizeof($types);
								for ($i = 0; $i < $qtd; $i++) { ?>
									<option value="<?php echo $types[$i]->id; ?>"><?php echo $types[$i]->type_name; ?></option>
								<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Arquivo:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="file" id="path_file" name="path_file" required />
								<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
							<center>
								<a href="{{route('cadastroDR', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
								<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
							</center>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
								<input hidden type="text" class="form-control" id="tela" name="tela" value="documentosRegularidade" />
								<input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDocumentosRegularidade" />
								<input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" />
							</div>
						</div>
					</div>
			    </div>
			</form>
        </div>
    </div>
@endsection