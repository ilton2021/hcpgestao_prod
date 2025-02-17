@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			@if($aditivos[0]->opcao == 1)
			<h3 style="font-size: 18px;">ALTERAR ADITIVO:</h3>
			@elseif($aditivos[0]->opcao == 2)
			<h3 style="font-size: 18px;">ALTERAR DISTRATO:</h3>
			@elseif($aditivos[0]->opcao == 3)
			<h3 style="font-size: 18px;">ALTERAR RERRATIFICAÇÃO:</h3>
			@else
			<h3 style="font-size: 18px;">ALTERAR CONTRATO.:</h3>
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
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Contratos -> Aditivos <i class="fas fa-check-circle"></i>
					</a>

					<form action="{{ route('updateAditivo', array($unidade->id, $aditivos[0]->id, $contratos[0]->id))}}" method="post" enctype="multipart/form-data">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table table-sm">
							<tr>
								<td style="width: 50px; font-size: 15x;"><b>Prestador:</b></td>
								<td colspan="2">
									<input class="form-control form-control-sm" placeholder="Dados do Prestador" readonly type="text" id="prestador" name="prestador" value="<?php echo $prestadores[0]->prestador; ?>" title="<?php echo $prestadores[0]->prestador; ?>">
								</td> 
							</tr>
							<tr>
								<td></td>
								<td colspan="2">
									<input class="form-control form-control-sm" placeholder="Dados do Prestador" readonly type="text" id="tipo_contrato" name="tipo_contrato" value="<?php echo $prestadores[0]->cnpj_cpf .' / '. $prestadores[0]->tipo_contrato .' / '. $prestadores[0]->tipo_pessoa; ?>">
								</td>
							</tr>
							@if(!empty($gestor))
							<tr>
								<td><b>Gestor:</b></td>
								<td colspan="2">
									<input class="form-control form-control-sm" placeholder="Dados do Prestador" type="text" id="tipo_contrato" name="tipo_contrato" value="<?php echo $gestores[0]->nome . ' / ' . $gestores[0]->setor; ?>" readonly>
								</td>
							</tr>
							@endif
						</table>
						<table border="0" class="table table-sm">
							<tr>
								<td style="font-size: 15px"><b>Tipo do Contrato:</b></td>
								<td>
									<select name="opcao" id="opcao" onchange="exibir('vinculo')" class="form-control form-control-sm">
										<option value="0" <?php if($aditivos[0]->opcao == 0) { echo 'selected'; } ?>>Contrato</option>
										<option value="1" <?php if($aditivos[0]->opcao == 1) { echo 'selected'; } ?>>Aditivo</option>
										<option value="2" <?php if($aditivos[0]->opcao == 2) { echo 'selected'; } ?>>Distrato</option>
										<option value="3" <?php if($aditivos[0]->opcao == 3) { echo 'selected'; } ?>>Rerratificação</option>
									</select>
								</td>
								<td style="font-size: 15px;"><b>Renovação Automática:</b></td>
								<td>
									<select name="renovacao_automatica" id="renovacao_automatica" class="form-control form-control-sm">
										<option value="0" <?php if($aditivos[0]->renovacao_automatica == 0) { echo 'selected'; } ?>> Não </option>
										<option value="1" <?php if($aditivos[0]->renovacao_automatica == 1) { echo 'selected'; } ?>> Sim </option>
									</select>
								</td>
							</tr>
							<tr name="vinculado" id="vinculado">
								<td name="vinculado2" id="vinculado2" style="font-size: 15px"><b>Motivo Aditivo:</b></td>
								<td name="vinculado2" id="vinculado2" style="font-size: 15px" colspan="3">
									<select name="motivo" id="motivo" class="form-control form-control-sm">
										<option value="0">Selecione..</option>
										 <option value="prorrogacao" <?php if ($aditivos[0]->motivo == 'prorrogacao') { echo 'selected'; } ?>>Prorrogação de vigência</option>
										 <option value="reajusteValor" <?php if ($aditivos[0]->motivo == 'reajusteValor') { echo 'selected'; } ?>>Reajuste de valores</option>
										 <option value="alteracaoQuantitativo" <?php if ($aditivos[0]->motivo == 'alteracaoQuantitativo') { echo 'selected'; } ?>>Alteração de quantitativo de consultas/equipamentos</option>
										 <option value="inclusaoClausulas" <?php if ($aditivos[0]->motivo == 'inclusaoClausulas') { echo 'selected'; } ?>>Inclusão de Cláusulas</option>
										 <option value="retiradaClausulas" <?php if ($aditivos[0]->motivo == 'retiradaClausulas') { echo 'selected'; } ?>>Retirada de Cláusula</option>
										 <option value="mudancaClausulas" <?php if ($aditivos[0]->motivo == 'mudancaClausulas') { echo 'selected'; } ?>>Mudança de Cláusulas</option>
										 <option value="formaPgto" <?php if ($aditivos[0]->motivo == 'formaPgto') { echo 'selected'; } ?>>Forma de pagamento</option>
										 <option value="mudancaEndereco" <?php if ($aditivos[0]->motivo == 'mudancaEndereco') { echo 'selected'; } ?>>Mudança de endereço</option>
										 <option value="cessaoCNPJ" <?php if ($aditivos[0]->motivo == 'cessaoCNPJ') { echo 'selected'; } ?>>Cessão CNPJ</option>
									</select>
								</td>
							</tr>
							<tr>
							    <td style="font-size: 15px"><b>Data Início:</b></td>
								<td> <input placeholder="Valor do Contrato" class="form-control form-control-sm" type="date" id="inicio" name="inicio" value="<?php echo $aditivos[0]->inicio; ?>" required /> </td>
								<td style="font-size: 15px"><b>Data Fim: </td>
								<td> <input placeholder="Valor do Contrato" class="form-control form-control-sm" type="date" id="fim" name="fim" value="<?php echo $aditivos[0]->fim; ?>" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Valor Mensal:</b></td>
								<td> <input class="form-control form-control-sm" placeholder="Valor do Contrato" type="number" id="valor" name="valor" value="<?php echo $aditivos[0]->valor; ?>" required /> </td>
								<td style="font-size: 15px"><b>Valor Global:</b></td>
								<td> <input class="form-control form-control-sm" placeholder="Valor do Contrato" type="number" id="valor_global" name="valor_global" value="<?php echo $aditivos[0]->valor_global; ?>" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Arquivo:</b></td>
								<td colspan="3">  
									<input class="form-control form-control-sm" type="file" id="file_path_" name="file_path_" value="{{ old('file_path_') }}" /> 
								</td>
							</tr>	
							<tr>
								<td> </td>
								<td colspan="3"> <input class="form-control form-control-sm" readonly type="text" id="file_path" name="file_path" value="<?php echo $aditivos[0]->file_path; ?>" /> </td>
							</tr>
							<tr>
								<td><b>Status:</b></td>
								<td colspan="3">
									<select class="form-control form-control-sm" id="inativa" name="inativa">
										<option value="0" <?php if($aditivos[0]->inativa == 0) { echo 'selected'; } ?>>Ativo</option>
										<option value="1" <?php if($aditivos[0]->inativa == 1) { echo 'selected'; } ?>>Inativo</option>
									</select>
								</td>
							</tr>
						</table>
						<table border="0" class="table table-sm">
							<tr>
								<td align="center" colspan="4"> 
									<a href="javascript:history.back();" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
									<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
								</td>
							</tr>
						</table>
						<table border="0" class="table table-sm">
							<tr>
								<input type="hidden" id="prestador_id" name="prestador_id" value="<?php echo $prestadores[0]->id; ?>" />
								<input type="hidden" id="contrato_id" name="contrato_id" value="<?php echo $contratos[0]->id; ?>" />
								<td colspan="2"> <input hidden class="form-control" type="number" id="yellow_alert" name="yellow_alert" value="" /> </td>
								<td colspan="2"> <input hidden class="form-control" type="number" id="red_alert" name="red_alert" value="" /> </td>
								<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarContratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
								<input type="hidden" id="id" name="id" value="" />
							</tr>
						</table>
						
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection