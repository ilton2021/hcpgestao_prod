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
			<h5 style="font-size: 18px;">ALTERAR RELATÓRIO ASSISTENCIAL:</h5>
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
			<form action="{{\Request::route('updateRA'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1">
								<label><b>Indicador:</b></label> 
							</div>
							<div class="col-md-4 mr-1">
								<select id="indicador_id" name="indicador_id" class="form-control form-control-sm" onchange="exibir_ocultar(this)">
									<option value="1"> 1. Consultas Médicas </option>
									<option value="2"> 2. Comissão de Controle </option>
								</select>
							</div>
							<div class="col-md-4 mr-1">
								<label><b>Ano de Referência:</b></label> 
							</div>
							<div class="col-md-2 mr-1"> <?php $ano = date('Y', strtotime('now')); ?>
								<select class="form-control form-control-sm" id="ano_ref" name="ano_ref" required>
									<?php for ($a = 2018; $a <= $ano; $a++) { ?>
									  @if($a == $ano)
										<option id="ano_ref" name="ano_ref" value="<?php echo $a; ?>" selected>{{ $a }}</option>
									  @else
										<option id="ano_ref" name="ano_ref" value="<?php echo $a; ?>">{{ $a }}</option>
									  @endif <?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-1">
								<label><b>Tipo Linha:</b></label>	
							</div>
							<div class="col-md-8 mr-1"> 
								<select class="form-control form-control-sm" id="tipolinha" name="tipolinha" required>
									<option id="tipolinha" name="tipolinha" value="0" <?php echo $anosRef[0]->tipolinha == 0 ? "selected" : ""; ?>>Comum</option>
									<option id="tipolinha" name="tipolinha" value="1" <?php echo $anosRef[0]->tipolinha == 1 ? "selected" : ""; ?>>Título</option>
								</select>		
							</div>		
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-1">
								<label><b>Descrição:</b></label>
							</div>
							<div class="col-md-8 mr-1"> 
								<input type="text" id="descricao" name="descricao" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->descricao; } else { echo ""; } ?>" class="form-control form-control-sm" required /> 										
							</div>
						</div>
					</div>
					<div id="vinculado">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-3 mr-1">
									<label><b>Meta Controlada/Mês:<b></label>
								</div>
								<div class="col-md-12 mr-1"> 
									<input type="text" id="meta" name="meta" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->meta; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1"> 
									<label><b>Janeiro:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="janeiro" name="janeiro" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->janeiro; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
								<div class="col-md-3 mr-1"> 
									<label><b>Fevereiro:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="fevereiro" name="fevereiro" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->fevereiro; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1"> 
									<label><b>Março:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="marco" name="marco" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->marco; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
								<div class="col-md-3 mr-1"> 
									<label><b>Abril:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="abril" name="abril" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->abril; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1"> 
									<label><b>Maio:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="maio" name="maio" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->maio; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
								<div class="col-md-3 mr-1"> 
									<label><b>Junho:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="junho" name="junho" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->junho; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1"> 
									<label><b>Julho:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="julho" name="julho" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->julho; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
								<div class="col-md-3 mr-1"> 
									<label><b>Agosto:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="agosto" name="agosto" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->agosto; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1"> 
									<label><b>Setembro:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="setembro" name="setembro" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->setembro; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
								<div class="col-md-3 mr-1"> 
									<label><b>Outubro:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="outubro" name="outubro" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->outubro; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>	
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1"> 
									<label><b>Novembro:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="novembro" name="novembro" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->novembro; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
								<div class="col-md-3 mr-1"> 
									<label><b>Dezembro:</b></label>
								</div>
								<div class="col-md-3 mr-1">
									<input type="text" id="dezembro" name="dezembro" value="<?php if (!empty($anosRef)) { echo $anosRef[0]->dezembro; } else { echo ""; } ?>" class="form-control form-control-sm" />
								</div>
							</div>
						</div>	
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-12 mr-1"> 
								<center>
									<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
									<input type="submit" class="btn btn-success btn-sm" value="Alterar" id="Salvar" name="Salvar" />		
								</center>
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-12 mr-1"> 
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
				</div>
			</div>
		</form>
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