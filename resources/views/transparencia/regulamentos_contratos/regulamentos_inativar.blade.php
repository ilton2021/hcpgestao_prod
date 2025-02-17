@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		   @if($regulamentos[0]->status == 0)
			<h3 style="font-size: 18px;">ATIVAR REGULAMENTOS - CONTRATO:</h3>
		   @else
		    <h3 style="font-size: 18px;">INATIVAR REGULAMENTOS - CONTRATO:</h3>
		   @endif
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
		<div class="col-md-8 col-sm-12">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success text-center" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Regulamentos - Contrato: <i class="fas fa-check-circle"></i>
					</a>
					<form action="{{\Request::route('inativarRC', $regulamentos[0]->id)}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-control" style="color:black">
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<label><strong>ID:</strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input style="max-width: 90px;" readonly="true" class="form-control" type="text" id="id" name="id" value="<?php echo $regulamentos[0]->id; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<label><strong>Título:</strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<input style="max-width: 500px;" readonly="true" class="form-control" type="text" id="title" name="title" value="<?php echo $regulamentos[0]->title; ?>" />
									</div>
								</div>
							</div>
							<div class="form-row mt-2">
								<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
									<div class="col-md-2 mr-2">
										<label><strong>Tipo:</strong></label>
									</div>
									<div class="col-md-10 mr-2">
										<select style="max-width: 500px;" readonly class="form-control" id="tipo" name="tipo"> 
										@if($regulamentos[0]->tipo == 1)
											<option value="<?php echo $regulamentos[0]->tipo; ?>">{{ 'Manuais' }}</option>
										@else
											<option value="<?php echo $regulamentos[0]->tipo; ?>">{{ 'Instruções Normativas' }}</option>
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
										<input style="max-width: 500px;" readonly="true" class="form-control" type="text" name="file_path" id="file_path" value="<?php echo $regulamentos[0]->caminho; ?>" />
									</div>
								</div>
							</div>
						</div>
						<table>
							<tr>
								<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="regulamentoContratos" /> </td>
								@if($regulamentos[0]->status == 0)
								  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarRegulamentoContratos" /> </td>
								@else
								  <td> <input hidden type="text" class="form-control" id="acao" name="acao" value="InativarRegulamentoContratos" /> </td>
								@endif
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							</tr>
						</table>
				</div>
				<div class="form-control mt-2">
					<div class="d-flex justify-content-between">
						<div class="ml-2" style="color:black">
							<p>
							<h6> Deseja realmente Inativar este Regulamento - Contrato?? </h6>
							</p>
						</div>
					</div>
					<div class="d-flex justify-content-between">
						<div class="p-2">
							<a href="{{route('regulamentosContratosCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div class="p-2">
						  @if($regulamentos[0]->status == 0)
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
						  @else
						    <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
						  @endif
						</div>
					</div>
				</div>
				</form>
			</div>
			<div class="col-md-2 col-sm-0"></div>
		</div>
	</div>
</div>
@endsection