@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR CONTRATAÇÕES:</h3>
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
						Contratos: <i class="fas fa-check-circle"></i>
					</a>
					<form action="{{\Request::route('storeContratos'), $unidade->id}}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table table-sm">
							<tr>
								<td style="width: 50px; font-size: 15x;"><b>Prestador:</b></td>
								<td colspan="2">
									@if (!empty($prestadores))
									  <input class="form-control form-control-sm"  readonly type="hidden" id="id" name="id" value="<?php echo $prestadores[0]->id; ?>">
									  <input class="form-control form-control-sm" placeholder="Dados do Prestador" readonly type="text" id="prestador" name="prestador" value="<?php echo $prestadores[0]->prestador; ?>" title="<?php echo $prestadores[0]->prestador; ?>">
									@else
									  <input class="form-control form-control-sm" placeholder="Dados do Prestador" readonly type="text" id="prestador" name="prestador" value="">
									@endif
								</td> 
								<td style="width: 50px">
									<a class="btn btn-danger btn-sm" href="{{route('pesquisarPrestador', $unidade->id)}}"> Pesquisar <i class="fas fa-search"></i></a>
								</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2">
									@if (!empty($prestadores))
									<input class="form-control form-control-sm" placeholder="Dados do Prestador" readonly type="text" id="tipo_contrato" name="tipo_contrato" value="<?php echo $prestadores[0]->cnpj_cpf .' / '. $prestadores[0]->tipo_contrato .' / '. $prestadores[0]->tipo_pessoa; ?>">
									@else
									<input class="form-control form-control-sm" placeholder="Dados do Prestador" readonly type="text" id="tipo_contrato" name="tipo_contrato" value="">
									@endif
								</td>
								<td>
								    <a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('prestadorLista', $unidade->id)}}"> Novo Prestador <i class="fas fa-check"></i></a>
								</td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Gestor:</b></td>
								<td colspan="2">
									 <select class="form-control form-control-sm" id="gestor_id" name="gestor_id" required> 
									  <option value="">Selecione...</option>
									  @foreach($gestores as $gestor)
									   @if($gestor->id == old('gestor_id'))
									  	 <option selected value="<?php echo $gestor->id; ?>">{{ strtoupper($gestor->nome) }} / {{ strtoupper($gestor->setor) }}</option>
									   @else
									     <option value="<?php echo $gestor->id; ?>">{{ strtoupper($gestor->nome) }} / {{ strtoupper($gestor->setor) }}</option>
									   @endif
									  @endforeach
									 </select>
								</td>
								<td>
								    <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroGE', $unidade->id)}}"> Novo Gestor <i class="fas fa-check"></i></a>
								</td>
							</tr>
							<input type="hidden" id="prestador_id" name="prestador_id" value="" />
						</table>
						<table border="0" class="table table-sm">
							<tr>
								<td style="font-size: 15px"><b>Título do Contrato:</b></td>
								<td colspan="3"> <input class="form-control form-control-sm" placeholder="Título do Contrato" type="text" id="objeto" name="objeto" value="{{ old('objeto') }}" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Tipo do Contrato:</b></td>
								<td>
									<select name="aditivos" id="aditivos" class="form-control form-control-sm">
									 	<option value="0" <?php if(old('aditivos') == '0') { ?> selected <?php } ?>>Contrato</option>
										<option value="1" <?php if(old('aditivos') == '1') { ?> selected <?php } ?>>Aditivo</option>
										<option value="2" <?php if(old('aditivos') == '2') { ?> selected <?php } ?>>Distrato</option>
										<option value="3" <?php if(old('aditivos') == '3') { ?> selected <?php } ?>>Rerratificação</option>
									</select>
								</td>
								<td style="font-size: 15px"><b>Renovação Automática:</b></td>
								<td>
									<select name="renovacao_automatica" id="renovacao_automatica" class="form-control form-control-sm">
										<option value="0"> Não </option>
										<option value="1"> Sim </option>
									</select>
								</td>
							</tr>
							<tr name="vinculado" id="vinculado" <?php if(old('aditivos') == '1') { ?> show <?php } ?>>
								<td name="vinculado2" id="vinculado2" style="font-size: 15px" <?php if(old('aditivos') == '1') { ?> show <?php } ?>><b>Motivo Aditivo:</b></td>
								<td name="vinculado2" id="vinculado2" style="font-size: 15px" <?php if(old('aditivos') == '1') { ?> show <?php } ?>>
									<select name="motivo" id="motivo" class="form-control form-control-sm">
										<option value="0">Selecione..</option>
										 <option value="prorrogacao" <?php if (old('motivo') == 'prorrogacao') { ?> selected <?php } ?>>Prorrogação de vigência</option>
										 <option value="reajusteValor" <?php if (old('motivo') == 'reajusteValor') { ?> selected <?php } ?>>Reajuste de valores</option>
										 <option value="alteracaoQuantitativo" <?php if (old('motivo') == 'alteracaoQuantitativo') { ?> selected <?php } ?>>Alteração de quantitativo de consultas/equipamentos</option>
										 <option value="inclusaoClausulas" <?php if (old('motivo') == 'inclusaoClausulas') { ?> selected <?php } ?>>Inclusão de Cláusulas</option>
										 <option value="retiradaClausulas" <?php if (old('motivo') == 'retiradaClausulas') { ?> selected <?php } ?>>Retirada de Cláusula</option>
										 <option value="mudancaClausulas" <?php if (old('motivo') == 'mudancaClausulas') { ?> selected <?php } ?>>Mudança de Cláusulas</option>
										 <option value="formaPgto" <?php if (old('motivo') == 'formaPgto') { ?> selected <?php } ?>>Forma de pagamento</option>
										 <option value="mudancaEndereco" <?php if (old('motivo') == 'mudancaEndereco') { ?> selected <?php } ?>>Mudança de endereço</option>
										 <option value="cessaoCNPJ" <?php if (old('motivo') == 'cessaoCNPJ') { ?> selected <?php } ?>>Cessão CNPJ</option>
									</select>
								</td>
								<td style="font-size: 15px"><b>Contrato:</b></td>
								<td>
									<select name="vinculado" id="vinculado" class="form-control form-control-sm">
										<option value="0">Selecione o contrato</option>
										@foreach($CP as $contratosPrestad)
										  <option value="{{$contratosPrestad}}">{{$contratosPrestad}}</option>
										@endforeach
									</select>
								</td>
							</tr>
							<tr>
							    <td style="font-size: 15px"><b>Data Início:</b></td>
								<td> <input placeholder="Valor do Contrato" class="form-control form-control-sm" type="date" id="inicio" name="inicio" value="{{ old('inicio') }}" required /> </td>
								<td style="font-size: 15px"><b>Data Fim: </td>
								<td> <input placeholder="Valor do Contrato" class="form-control form-control-sm" type="date" id="fim" name="fim" value="{{ old('fim') }}" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Valor Mensal:</b></td>
								<td> <input class="form-control form-control-sm" placeholder="Valor do Contrato" type="number" id="valor" name="valor" value="{{ old('valor') }}" required /> </td>
								<td style="font-size: 15px"><b>Valor Global:</b></td>
								<td> <input class="form-control form-control-sm" placeholder="Valor do Contrato" type="number" id="valor_global" name="valor_global" value="{{ old('valor_global') }}" required /> </td>
							</tr>
							<tr>
							<td style="font-size: 15px"><b>Arquivo:</b></td>
								<td colspan="1">  
									<input class="form-control form-control-sm" type="file" id="file_path" name="file_path" value="{{ old('file_path') }}" /> 
								</td>
								<td>
									<div class="row">
										<label for="" style="margin-left: 20px;"><b>Renovação +36:</b></label>
										<div class="col">SIM <input type="radio" name="renovacao36" id="renovacao36" value="1"></div>
										<div class="col">NÃO <input type="radio" name="renovacao36" id="renovacao36" value="0"></div>
									</div>
								</td>
						</table>

						<table border="0" class="table table-sm">
							<tr>
								<td align="center" colspan="5"> 
									<a href="{{route('contratacaoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
									<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
								</td>
							</tr>
						</table>
						<table border="0" class="table">
							<tr>
								<td> <input hidden class="form-control" type="number" id="yellow_alert" name="yellow_alert" value="" /> </td>
								<td> <input hidden class="form-control" type="number" id="red_alert" name="red_alert" value="" /> </td>
						    	<td> <input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /> </td>
								<td> <input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" id="cadastro" name="cadastro" value="1" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarContratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								@foreach($CP as $contratosPrestad)
								<td><input hidden type="checkbox" id="CP[]" class="CP" name="CP[]" value="<?php echo $contratosPrestad; ?>" checked></input></td>
								@endforeach
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td> 
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$('#vinculado').hide();
		$('#vinculado2').hide();
		$('#aditivos').change(function() {
			if ($('#aditivos').val() == 1) {
				$('#vinculado').show();
				$('#vinculado2').show();
				$('#motivo').show();
			} else if ($('#aditivos').val() == 0) {
				$('#vinculado').hide();
				$('#vinculado2').hide();
				$('#motivo').hide();
			} else {
				$('#vinculado').show();
				$('#vinculado2').hide();
				$('#motivo').hide();
			}
		});
	});
</script>
<script>
	
	function renovacao(){
		if(document.getElementById('renovacao36Sim').checked){
			document.getElementById('renovacao36Active').innerHTML = '<p style="color: red;">Pesquisa de mercado</p>';
		} else{
			document.getElementById('renovacao36Active').innerHTML = '';
		}
	}
</script>
@endsection