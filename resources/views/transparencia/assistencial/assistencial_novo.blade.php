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
			<form action="{{\Request::route('storeRA'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1">
								<label><b>Indicador:</b></label> 
							</div>
							<div class="col-md-5 mr-1">
								<select id="indicador_id" name="indicador_id" class="form-control form-control-sm" onchange="exibir_ocultar(this)">
									<option value="1"> 1. Consultas Médicas </option>
									<option value="2"> 2. Comissão de Controle </option>
								</select>
							</div>
							<div class="col-md-3 mr-1">
								<label><b>Ano de Referência:</b></label>	
							</div>
							<div class="col-md-2 mr-1"> <?php $ano = date('Y', strtotime('now')); ?>
								<select class="form-control form-control-sm" id="ano_ref" name="ano_ref">
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
									<option value="0" selected>Comum</option>
									<option value="1">Título</option>
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
								<input type="text" id="descricao" name="descricao" value="{{ old('descricao') }}" class="form-control form-control-sm" required /> 
							</div>
						</div>
					</div>
					<div id="vinculado">
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-1"> 
								<label><b>Meta Controlada/Mês:</b></label>				
							</div>
							<div class="col-md-8 mr-1">
								<input type="text" id="meta" name="meta" value="{{ old('meta') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1"> 
								<label><b>Janeiro:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="janeiro" name="janeiro" value="{{ old('janeiro') }}" class="form-control form-control-sm" />
							</div>
							<div class="col-md-3 mr-1"> 
								<label><b>Fevereiro:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="fevereiro" name="fevereiro" value="{{ old('fevereiro') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1"> 
								<label><b>Março:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="marco" name="marco" value="{{ old('marco') }}" class="form-control form-control-sm" />
							</div>
							<div class="col-md-3 mr-1"> 
								<label><b>Abril:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="abril" name="abril" value="{{ old('abril') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1"> 
								<label><b>Maio:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="maio" name="maio" value="{{ old('maio') }}" class="form-control form-control-sm" /> 
							</div>
							<div class="col-md-3 mr-1"> 
								<label><b>Junho:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="junho" name="junho" value="{{ old('junho') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1"> 
								<label><b>Julho:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="julho" name="julho" value="{{ old('julho') }}" class="form-control form-control-sm" />
							</div>
							<div class="col-md-3 mr-1"> 
								<label><b>Agosto:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="agosto" name="agosto" value="{{ old('agosto') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1"> 
								<label><b>Setembro:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="setembro" name="setembro" value="{{ old('setembro') }}" class="form-control form-control-sm" />
							</div>
							<div class="col-md-3 mr-1"> 
								<label><b>Outubro:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="outubro" name="outubro" value="{{ old('outubro') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1"> 
								<label><b>Novembro:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="novembro" name="novembro" value="{{ old('novembro') }}" class="form-control form-control-sm" /> 
							</div>
							<div class="col-md-3 mr-1"> 
								<label><b>Dezembro:</b></label>
							</div>
							<div class="col-md-3 mr-1">
								<input type="text" id="dezembro" name="dezembro" value="{{ old('dezembro') }}" class="form-control form-control-sm" />
							</div>
						</div>
					</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-1"> 
							  <center>
								<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
								<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Adicionar" id="Salvar" name="Salvar" />
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
			</form>
			<div class="form-control mt-3" style="color:black">
				<div class="form-row mt-3">
					<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
						<div class="col-md-12 mr-1"> 
							<button class="btn btn-success" id="slideLeft" type="button"><-</button>
							<button class="btn btn-success" id="slideRight" type="button" style="align: right">-></button>
						</div>
					</div>
				</div>
			</div>
			<div class="form-control mt-3" style="color:black">
				<div class="form-row mt-3">
					<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
					  <div class="col-md-12 mr-1"> 
						<div class="content mt-2" style="overflow:hidden; height:45px" id="buttonScroll">
						  <table class="rTable">
							<thead>
							  <tr>
								<th class="p-2" scope="col">Alterar</th>
								<th class="p-2" scope="col">Descrição</th>
								<th class="p-2" scope="col">Meta</th>
								<th class="p-2" scope="col">Janeiro</th>
								<th class="p-2" scope="col">Fevereiro</th>
								<th class="p-2" scope="col">Março</th>
								<th class="p-2" scope="col">Abril</th>
								<th class="p-2" scope="col">Maio</th>
								<th class="p-2" scope="col">Junho</th>
								<th class="p-2" scope="col">Julho</th>
								<th class="p-2" scope="col">Agosto</th>
								<th class="p-2" scope="col">Setembro</th>
								<th class="p-2" scope="col">Outubro</th>
								<th class="p-2" scope="col">Novembro</th>
								<th class="p-2" scope="col">Dezembro</th>
							  </tr>
							</thead>
							<tbody>
							  <tr>
								<td> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="#"> Alterar <i class="fas fa-edit"></i></a></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>
								<td class="p-2"> <textarea class="form-control text-left" type="text" id="" name="" title="" readonly  style="width:250px"></textarea></td>	
							  </tr>
							</tbody>
						  </table>
						</div>
						<div class="content mt-2" style="overflow-x:hidden; height: 70vh;" id="buttonScroll2">
							<table class="rTable">
								<thead>
									<tr>
										<th hidden class="p-2" scope="col">Alterar</th>
										<th hidden class="p-2" scope="col">Descrição</th>
										<th hidden class="p-2" scope="col">Meta</th>
										<th hidden class="p-2" scope="col">Janeiro</th>
										<th hidden class="p-2" scope="col">Fevereiro</th>
										<th hidden class="p-2" scope="col">Março</th>
										<th hidden class="p-2" scope="col">Abril</th>
										<th hidden class="p-2" scope="col">Maio</th>
										<th hidden class="p-2" scope="col">Junho</th>
										<th hidden class="p-2" scope="col">Julho</th>
										<th hidden class="p-2" scope="col">Agosto</th>
										<th hidden class="p-2" scope="col">Setembro</th>
										<th hidden class="p-2" scope="col">Outubro</th>
										<th hidden class="p-2" scope="col">Novembro</th>
										<th hidden class="p-2" scope="col">Dezembro</th>
									</tr>
								</thead>
								@if(!empty($anosRef))
								@foreach($anosRef as $aRef)
								<tbody>
									<tr>
										<td> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('alterarRA', array($unidade->id, $aRef->id))}}"> Alterar <i class="fas fa-edit"></i></a> </td>
										@if($aRef->tipolinha == 1)
										<td colspan="14" class="p-2">
											<div class="d-inline-flex d-flex justify-content-around form-control text-left bg-success">
												<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
												<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
												<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
												<label class="" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="color:white; font-weight: bold;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly="true">{{$aRef->descricao}}</label>
											</div>
										</td>
										@else
										<td class="p-2"> <textarea class="form-control text-left" <?php echo $aRef->descricao == "" ? 'hidden' : 'style="width:250px;"'; ?> type="text" id="desc" name="desc" title="<?php echo $aRef->descricao; ?>" readonly style="width:250px">{{$aRef->descricao}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="met" name="met" value="<?php echo $aRef->meta; ?>" title="<?php echo $aRef->meta; ?>" readonly style="width:250px">{{$aRef->meta}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="jan" name="jan" value="<?php echo $aRef->janeiro; ?>" title="<?php echo $aRef->janeiro; ?>" readonly style="width:250px">{{$aRef->janeiro}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="fev" name="fev" value="<?php echo $aRef->fevereiro; ?>" title="<?php echo $aRef->fevereiro; ?>" readonly style="width:250px">{{$aRef->fevereiro}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="mar" name="mar" value="<?php echo $aRef->marco; ?>" title="<?php echo $aRef->marco; ?>" readonly style="width:250px">{{$aRef->marco}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="abr" name="abr" value="<?php echo $aRef->abril; ?>" title="<?php echo $aRef->abril; ?>" readonly style="width:250px">{{$aRef->abril}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="mai" name="mai" value="<?php echo $aRef->maio; ?>" title="<?php echo $aRef->maio; ?>" readonly style="width:250px">{{$aRef->maio}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="jun" name="jun" value="<?php echo $aRef->junho; ?>" title="<?php echo $aRef->junho; ?>" readonly style="width:250px">{{$aRef->junho}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="jun" name="jun" value="<?php echo $aRef->junho; ?>" title="<?php echo $aRef->junho; ?>" readonly style="width:250px">{{$aRef->julho}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="ago" name="ago" value="<?php echo $aRef->agosto; ?>" title="<?php echo $aRef->agosto; ?>" readonly style="width:250px">{{$aRef->agosto}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="set" name="set" value="<?php echo $aRef->setembro; ?>" title="<?php echo $aRef->setembro; ?>" readonly style="width:250px">{{$aRef->setembro}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="out" name="out" value="<?php echo $aRef->outubro; ?>" title="<?php echo $aRef->outubro; ?>" readonly style="width:250px">{{$aRef->outubro}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="nov" name="nov" value="<?php echo $aRef->novembro; ?>" title="<?php echo $aRef->novembro; ?>" readonly style="width:250px">{{$aRef->novembro}}</textarea></td>
										<td class="p-2"> <textarea class="form-control text-left" type="text" id="dez" name="dez" value="<?php echo $aRef->dezembro; ?>" title="<?php echo $aRef->dezembro; ?>" readonly style="width:250px">{{$aRef->dezembro}}</textarea></td>
										@endif
									</tr>
								</tbody>
								@endforeach
								@endif
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="form-control mt-3" style="color:black">
				<div class="form-row mt-3">
					<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
						<div class="col-md-12 mr-1"> 
							<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
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