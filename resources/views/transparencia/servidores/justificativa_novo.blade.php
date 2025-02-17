@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR JUSTIFICATIVA: {{ $tela }} </h3>
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
						Justificativa: <i class="fas fa-check-circle"></i>
					</a>
				</div> 
				<form action="{{ route('storeJS', array($unidade->id, $id)) }}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" type="text" id="nome" name="nome" value="{{ old('nome') }}" required />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1">
									<label><strong>Mês:</strong></label>
								</div> 
								<div class="col-md-4 mr-2">
									<select class="form-control" type="text" name="mes" id="mes">
										<option value="">Selecione...</option>
										<option value="1">Janeiro</option>	
										<option value="2">Fevereiro</option>	
										<option value="3">Março</option>	
										<option value="4">Abril</option>	
										<option value="5">Maio</option>	
										<option value="6">Junho</option>	
										<option value="7">Julho</option>	
										<option value="8">Agosto</option>	
										<option value="9">Setembro</option>	
										<option value="10">Outubro</option>	
										<option value="11">Novembro</option>	
										<option value="12">Dezembro</option>	
									</select>
								</div>
								<div class="col-md-2 mr-0">
									<label><strong>Ano:</strong></label>
								</div> <?php $ano = date("Y", strtotime('now')); ?>
								<div class="col-md-4 mr-0">
									<select class="form-control" type="text" name="ano" id="ano">
									    <option selected value="2022">2022</option>	
									   <option selected value="<?php echo $ano; ?>">{{ $ano }}</option>	
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
									<input class="form-control" type="file" name="file_path" id="file_path" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="registro_id" name="registro_id" value="" /> </td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="justificativaNova" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarJustificativa" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>

					<div class="d-flex justify-content-between">
						<div>
							<a href="javascript:history.back();" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
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