@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR REGULAMENTOS - CONTRATO:</h3>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Regulamentos - Contrato: <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{\Request::route('storeRC'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input style="max-width: 500px" class="form-control" type="text" id="title" name="title" value="{{ old('title') }}" required />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Tipo:</strong></label>
								</div>
								<div class="col-md-12 mr-2 d-inline-flex flex-wrap justify-content-sm-center justify-content-md-start">
									<select class="form-control" id="tipo" name="tipo" style="max-width: 460px;">
									  @if(old('tipo') == 1)
										<option value="1" selected>Manuais</option>
										<option value="2">Instruções Normativas</option>
									  @elseif(old('tipo') == 2)
									    <option value="1">Manuais</option>
										<option value="2" selected>Instruções Normativas</option>
									  @else
									    <option value="1">Manuais</option>
										<option value="2">Instruções Normativas</option>
									  @endif
									</select>
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Arquivo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" type="file" name="file_path" id="file_path" style="max-width: 500px;" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="regulamentosContratos" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRegulamentosContratos" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div class="d-flex justify-content-between">
						<div>
							<a href="{{route('regulamentosContratosCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
						</div>
						<div>
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-2 col-sm-0"></div>
		</div>
	</div>
</div>
@endsection