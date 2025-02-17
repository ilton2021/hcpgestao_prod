@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR DEMONSTRAÇÕES CONTÁBEIS E PARECERES:</h3>
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
						Demonstrações Contabéis e Pareceres: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{\Request::route('storeDC'), $unidade->id}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Título:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="text" id="title" name="title" value="{{ old('title') }}" required />
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Ano:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<?php $ano = date('Y', strtotime('now')); ?>
								<select class="form-control form-control-sm" id="ano" name="ano" required>
									<?php for ($a = 2020; $a <= 2025; $a++) { ?>
										@if($a == $ano)
										<option value="<?php echo $a; ?>" selected>{{ $a }}</option>
										@else
										<option value="<?php echo $a; ?>">{{ $a }}</option>
										@endif
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Arquivo:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="file" name="file_path" id="file_path" required />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
							<center>
								<a href="{{route('cadastroDC', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
								<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
							</center>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
								<input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoContabel" /> 
								<input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDemonstrativoContabel" /> 
								<input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> 
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection