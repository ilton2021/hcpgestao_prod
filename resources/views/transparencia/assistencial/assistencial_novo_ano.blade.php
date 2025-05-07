@extends('navbar.default-navbar')
<style>
	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	.content {
		display: flex;
		margin: auto;

	}

	.rTable {
		width: 100%;
		text-align: center;

	}

	.rTable thead {
		background: #28a745;
		font-weight: bold;
		color: #fff;
	}

	.rTable tbody tr:nth-child(2n) {
		background: #ccc;
	}

	.rTable th,
	.rTable td {
		padding: 7px 0;
	}

	@media screen and (max-width: 480px) {
		.content {
			width: 94%;
		}

		.rTable thead {
			display: none;
		}

		.rTable tbody td {
			display: flex;
			flex-direction: column;
		}
	}

	@media only screen and (min-width: 1200px) {
		.content {
			width: 100%;
		}

		.rTable tbody tr td:nth-child(1) {
			width: 10%;
		}

		.rTable tbody tr td:nth-child(2) {
			width: 30%;
		}

		.rTable tbody tr td:nth-child(3) {
			width: 20%;
		}

		.rTable tbody tr td:nth-child(4) {
			width: 10%;
		}

		.rTable tbody tr td:nth-child(5) {
			width: 30%;
		}
	}
</style>
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CADASTRAR RELATÓRIO ASSISTENCIAL:</h5>
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
						Relatório Assistencial: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{\Request::route('novoAnoRA'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input hidden type="text" id="descricao" name="descricao" value="{{ old('descricao') }}" /> 
				<input hidden type="text" id="indicador_id" name="indicador_id" value="{{ old('indicador_id') }}" /> 
				<input hidden type="text" id="tipolinha" name="tipolinha" value="{{ old('tipolinha') }}" /> 
				<input hidden type="text" id="meta" name="meta" value="{{ old('meta') }}" /> 
				<input hidden type="text" id="janeiro" name="janeiro" value="{{ old('janeiro') }}" /> 
				<input hidden type="text" id="fevereiro" name="fevereiro" value="{{ old('fevereiro') }}" /> 
				<input hidden type="text" id="marco" name="marco" value="{{ old('marco') }}" /> 
				<input hidden type="text" id="abril" name="abril" value="{{ old('abril') }}" /> 
				<input hidden type="text" id="maio" name="maio" value="{{ old('maio') }}" /> 
				<input hidden type="text" id="junho" name="junho" value="{{ old('junho') }}" /> 
				<input hidden type="text" id="julho" name="julho" value="{{ old('julho') }}" /> 
				<input hidden type="text" id="agosto" name="agosto" value="{{ old('agosto') }}" /> 
				<input hidden type="text" id="setembro" name="setembro" value="{{ old('setembro') }}" /> 
				<input hidden type="text" id="outubro" name="outubro" value="{{ old('outubro') }}" /> 
				<input hidden type="text" id="novembro" name="novembro" value="{{ old('novembro') }}" /> 
				<input hidden type="text" id="dezembro" name="dezembro" value="{{ old('dezembro') }}" /> 
				<input hidden type="text" id="unidade_id" name="unidade_id" value="{{ old('unidade_id') }}" /> 
				<input hidden type="text" id="ano_ref" name="ano_ref" value="{{ old('ano_ref') }}" /> 
				<input hidden type="text" id="status_assistencials" name="status_assistencials" value="{{ old('status_assistencials') }}" /> 
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-1"> 
							  <center>
								<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Adicionar Novo Ano" id="Salvar" name="Salvar" />
							  </center>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<div class="form-control mt-3" style="color:black">
				<div class="form-row mt-3">
					<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
						<div class="col-md-12 mr-1"> 
							<center>
								<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	const buttonRight = document.getElementById('slideRight');
	const buttonLeft = document.getElementById('slideLeft');

	buttonRight.onclick = function() {
		document.getElementById('buttonScroll').scrollLeft += 300;
		document.getElementById('buttonScroll2').scrollLeft += 300;
	};
	buttonLeft.onclick = function() {
		document.getElementById('buttonScroll').scrollLeft -= 300;
		document.getElementById('buttonScroll2').scrollLeft -= 300;
	};

	//Exibição de campos
	$(document).ready(function() {
		$('#vinculado').show();
		$('#tipolinha').change(function() {
			if ($('#tipolinha').val() !== 0) {
				$('#vinculado').hide();
			} else {
				$('#vinculado').show();
			}
		});
		$('#tipolinha').change(function() {
			if ($('#tipolinha').val() == 0) {
				$('#vinculado').show();
			} else {
				$('#vinculado').hide();
			}
		});
	});
</script>
@endsection