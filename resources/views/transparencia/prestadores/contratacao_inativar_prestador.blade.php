@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		  @if($prestadores[0]->status_prestadors == 1)
			<h5 style="font-size: 18px;">ATIVAR PRESTADOR:</h5>
		  @else
		    <h5 style="font-size: 18px;">INATIVAR PRESTADOR:</h5>
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
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded aria-controls="PESSOAL">
					  PRESTADORES: <i class="fas fa-check-circle"></i>
					</a>
				</div>
				<form action="{{ route('inativarPrestador', array($unidade->id, $prestadores[0]->id))}}" method="post" id="formid">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Nome:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control form-control-sm" style="max-width: 400px;" type="text" id="name" name="name" value="<?php echo $prestadores[0]->prestador; ?>" disabled />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>CPF/CNPJ:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control form-control-sm" style="max-width: 400px;" type="text" id="cnp_cnpj" name="cnp_cnpj" value="<?php echo $prestadores[0]->cnpj_cpf; ?>" disabled />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Tipo Contrato:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control form-control-sm" style="max-width: 400px;" type="text" id="tipo_contrato" name="tipo_contrato" value="<?php echo $prestadores[0]->tipo_contrato; ?>" disabled />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<labe><strong>Tipo Pessoa:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control form-control-sm" style="max-width: 400px;" type="text" id="tipo_pessoa" name="tipo_pessoa" value="<?php echo $prestadores[0]->tipo_pessoa; ?>" disabled />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control form-control-sm" id="tela" name="tela" value="prestadores" /> </td>
							@if($prestadores[0]->status_prestadors == 1)
							<td> <input hidden type="text" class="form-control form-control-sm" id="acao" name="acao" value="AtivarPrestador" /> </td>
							@else
							<td> <input hidden type="text" class="form-control form-control-sm" id="acao" name="acao" value="InativarPrestador" /> </td>
							@endif
							<td> <input hidden type="text" class="form-control form-control-sm" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
					<div class="form-control">
						<div class="d-flex justify-content-between">
							<div class="ml-2 col-12" style="color: black;">
								<center>
								 @if($prestadores[0]->status_prestadors == 1)
								  <h6> Deseja realmente Ativar este Prestador?? </h6> 
								 @else
								  <h6> Deseja realmente Inativar este Prestador?? </h6> 
								 @endif
								</center>
							</div>
						</div>
						<div class="d-flex justify-content-between">
							<div class="p-2">
								<a href="{{route('prestadorLista', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							</div>
							<div class="p-2" id="containerEnviar">
							    @if($prestadores[0]->status_prestadors == 1)
								  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
								@else
								  <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
								@endif
								<div id="blockEnviar"></div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection