@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR CONTRATAÇÕES:</h3>
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
						Contratos: <i class="fas fa-check-circle"></i>
					</a>
					<form action="{{\Request::route('updateContratos'), $unidade->id}}" method="post" enctype="multipart/form-data">
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
								<tr> <?php $qtd = sizeof($gestor); ?>
								 @if($qtd > 0)
									<td><b>Gestor:</b></td>
									<td>
									 <select class="form-control form-control-sm" id="gestor_id" name="gestor_id" required> 
									  <option value="">Selecione...</option>
									  @foreach($gestores as $gestorC)
									   @if($gestorC->id == $gestor[0]->id)
									  	 <option selected value="<?php echo $gestorC->id; ?>">{{ strtoupper($gestorC->nome) }} / {{ strtoupper($gestorC->setor) }}</option>
									   @else
									     <option value="<?php echo $gestorC->id; ?>">{{ strtoupper($gestorC->nome) }} / {{ strtoupper($gestorC->setor) }}</option>
									   @endif
									  @endforeach
									</td>
									<td>
								      <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroGE', $unidade->id)}}"> Novo Gestor <i class="fas fa-check"></i></a>
									</td>
								 @else
									<td><b>Gestor:</b></td>
									<td>
									 <select class="form-control form-control-sm" id="gestor_id" name="gestor_id" required>
									  <option value="">Selecione...</option> 
									   @foreach($gestores as $gestorC)
									     <option value="<?php echo $gestorC->id; ?>">{{ strtoupper($gestorC->nome) }} / {{ strtoupper($gestorC->setor) }}</option>
									   @endforeach
									 </select>
									</td>
									<td>
								      <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroGE', $unidade->id)}}"> Novo Gestor <i class="fas fa-check"></i></a>
									</td>
								 @endif  
								</tr>
								<input type="hidden" id="prestador_id" name="prestador_id" value="" />
								<input type="hidden" id="contrato_id" name="contrato_id" value="<?php echo $contratos[0]->id; ?>" />
						</table> 
						
						<table border="0" class="table table-sm">
							<tr>
								<td style="font-size: 15px"><b>Título do Contrato:</b></td>
								<td colspan="3"> <input class="form-control form-control-sm" placeholder="Título do Contrato" type="text" id="objeto" name="objeto" value="<?php echo $contratos[0]->objeto; ?>" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Tipo do Contrato:</b></td>
								<td>
									<select name="aditivos" id="aditivos" readonly class="form-control form-control-sm">
									 	<option value="0">Contrato</option>
									</select>
								</td> 
								<td style="font-size: 15px; width: 200px;"><b>Renovação Automática:</b></td>
								<td>
									<select name="renovacao_automatica" id="renovacao_automatica" class="form-control form-control-sm">
										<option value="0" <?php if($contratos[0]->renovacao_automatica == 0) { echo 'selected'; } ?>> Não </option>
										<option value="1" <?php if($contratos[0]->renovacao_automatica == 1) { echo 'selected'; } ?>> Sim </option>
									</select>
								</td>
							</tr>
							<tr>
							    <td style="font-size: 15px"><b>Data Início:</b></td>
								<td> <input placeholder="Valor do Contrato" class="form-control form-control-sm" type="date" id="inicio" name="inicio" value="<?php echo $contratos[0]->inicio; ?>" required /> </td>
								<td style="font-size: 15px"><b>Data Fim: </td>
								<td> <input placeholder="Valor do Contrato" class="form-control form-control-sm" type="date" id="fim" name="fim" value="<?php echo $contratos[0]->fim; ?>" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Valor Mensal:</b></td>
								<td> <input class="form-control form-control-sm" placeholder="Valor do Contrato" type="number" id="valor" name="valor" value="<?php echo $contratos[0]->valor; ?>" required /> </td>
								<td style="font-size: 15px"><b>Valor Global:</b></td>
								<td> <input class="form-control form-control-sm" placeholder="Valor do Contrato" type="number" id="valor_global" name="valor_global" value="<?php echo $contratos[0]->valor_global; ?>" required /> </td>
							</tr>
							<tr>
								<td style="font-size: 15px"><b>Arquivo:</b></td>
								<td colspan="3">  
									<input class="form-control form-control-sm" type="file" id="file_path_" name="file_path_" value="{{ old('file_path_') }}" /> 
								</td>
							</tr>	
							<tr>
								<td> </td>
								<td colspan="3"> <input class="form-control form-control-sm" readonly type="text" id="file_path" name="file_path" value="<?php echo $contratos[0]->file_path; ?>" /> </td>
							</tr>
							<tr>
								<td><b>Status:</b></td>
								<td>
									<select class="form-control form-control-sm" id="inativa" name="inativa" required>
										<option value="0" <?php if($contratos[0]->inativa == 0) { echo 'selected'; } ?>>Ativo</option>
										<option value="1" <?php if($contratos[0]->inativa == 1) { echo 'selected'; } ?>>Inativo</option>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="4"> <input hidden class="form-control" type="number" id="yellow_alert" name="yellow_alert" value="" /> </td>
							</tr>
							<tr>
								<td colspan="4"> <input hidden class="form-control" type="number" id="red_alert" name="red_alert" value="" /> </td>
							</tr>
						</table>
						<table> 
							<tr>
								<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="contratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarContratacao" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							</tr>
						</table>
						<table>
							<input type="hidden" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							<?php if (sizeof($contratos) > 0) { ?>
								<input type="hidden" id="id" name="id" value="<?php echo $contratos[0]->id; ?>" />
							<?php } else {
							} ?>
							<tr>
								<table class="table table-sm" id="" name="">
									<thead>
										<tr>
											<th scope="col">CNPJ</th>
											<th scope="col">Empresa</th>
											<th scope="col">Visualizar</th>
											<th scope="col">Tipo</th>
											<th scope="col">Contrato</th>
											<th scope="col">Alterar</th>
											<th scope="col">Excluir</th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 1; ?>
										<?php $j = 1; ?>
										<?php $a = 1; ?>
										<?php $c = 1; ?>
										<?php $id = 0; ?>
										<?php $aditivoVincula = 1; ?>
										@foreach ($vinculos as $contrato)
										<tr>
											<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
											<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
											<td>
												@if($contrato->ativa == 1 && $contrato->inativa == 0)
												<a class="badge badge-pill badge-primary dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false" href="{{$contrato->file_path}}" target="_blank">
													Visualizar
												</a>
												@elseif($contrato->ativa == 0 && $contrato->inativa == 0)
												<a class="badge badge-pill badge-primary dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false" href="{{asset('storage')}}/{{$contrato->file_path}}" target="_blank">
													Visualizar
												</a>
												@endif
											</td>
											<td>
												@if($contrato->opcao == 0)
												<?php $c++; ?>
												{{$c}}º Contrato
												@elseif($contrato->opcao == 1)
												<?php
												$id += 1;
												if (substr($contrato->vinculado, 0, 1) != $aditivoVincula) {
													$id = 1;
												}
												$aditivoVincula = substr($contrato->vinculado, 0, 1)
												?>
												{{$id}}º Aditivo
												@elseif($contrato->opcao == 2)
												Distrato
												@elseif($contrato->opcao == 3)
												Rerratificação
												@endif
											</td>
											@if($contrato->opcao !== 0)
											<td>
												<center>
													<input type="hidden" id="id_<?php echo $i ?>" name="id_<?php echo $i ?>" value="<?php echo $contrato->aditivo_ID; ?>" />
													<?php $i++; ?>
													<select style="width: 150px;" name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" style="width: 300px;" class="form-control">
														<option name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" value="1º Contrato">1° Contrato </option>
														@foreach($ccontratos as $cont)
														<?php $a++; ?>
														@if($a.'º Contrato' == $contrato->vinculado)
														<option name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" value="<?php echo $a . 'º Contrato'; ?>" selected>{{$a.'° Contrato'}}</option>
														@else
														<option name="cont_<?php echo $j ?>" id="cont_<?php echo $j ?>" value="<?php echo $a . 'º Contrato'; ?>">{{$a.'° Contrato'}}</option>
														@endif
														@endforeach
													</select>
												</center>
											</td>
											<input type="hidden" id="i" name="i" value="<?php echo $j ?>" />
											<?php $j++; ?>
											@else
											<td>
											</td>
											@endif
											<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
												<a id="div" class="dropdown-item" target="_blank">Contrato</a>
												@foreach($vinculos as $aditivo)
												<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}" target="_blank">Contrato</a></strong>
												@endforeach
											</div>
											</td>
											<td> <a class="btn btn-info btn-sm" href="{{route('alterarAditivo', array($unidade->id, $contrato->aditivo_ID,$contrato->cont_id))}}" style="color: #FFFFFF;" href=><i class="fas fa-edit"></i></a> </td>
											<td> <a class="btn btn-danger btn-sm" href="{{route('excluirAditivo', array($unidade->id, $contrato->aditivo_ID))}}" style="color: #FFFFFF;" href=><i class="fas fa-trash"></i></a> </td>
										</tr>
										<?php $a = 1; ?>
										@endforeach
									</tbody>
								</table>
								<table>
									<td align="left"> <br /><br /> <a href="{{route('contratacaoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
										<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
									</td>
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