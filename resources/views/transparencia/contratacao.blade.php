@extends('navbar.default-navbar')

@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CONTRATAÇÕES</h3>
		</div>
	</div>
	@if ($errors->any())
	<div class="alert alert-success">
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
				<!-- REGULAMENTOS -->
				<div class="card">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<a class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<strong>Regulamentos</strong>
							</a>
							@if(Auth::check()) 
							 @foreach ($permissao_users as $permissao)  
							  @if (($permissao->permissao_id == 28) && ($permissao->user_id == Auth::user()->id)) 
						 	   @if ($permissao->unidade_id == $unidade->id) 
							    <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('regulamentosContratosCadastro', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
							   @endif
							  @endif
							 @endforeach
							@endif
						</h2>
					</div>
					<div id="collapseOne" class="collapse multi-collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body"> <?php $a = 2; ?>
							<div class="row">
								<div class="col-6">
									<h6 class="text-success"><strong>Manuais</strong></h6>
									<ul class="list-group">
									 @foreach($regulamentos as $reg)
									  @if($reg->tipo == 1 && $reg->status == 1)
										<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{$reg->caminho}}" target="_blank">{{ $reg->title }}<i style="color: green; margin-left: 5px;" class="fas fa-download"></i></a></li>
									  @endif
									 @endforeach
									</ul>
								</div>
								<div class="col-6">
									<h6 class="text-success"><strong>Instruções normativas</strong></h6>
									<ul class="list-group">
									 @foreach($regulamentos as $reg)
									  @if($reg->tipo == 2 && $reg->status == 1)
										<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{$reg->caminho}}" target="_blank">{{ $reg->title }}<i style="color: green; margin-left: 5px;" class="fas fa-download"></i></a></li>
									  @endif
								  	 @endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- COTAÇÕES -->
				<div class="card">
					<div class="card-header" id="headingTwo">
						<h2 class="mb-0">
							<a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								<strong>Cotações</strong>
							</a>
							@if(Auth::check())
							 @foreach ($permissao_users as $permissao)
							  @if(($permissao->permissao_id == 10) && ($permissao->user_id == Auth::user()->id))
						 	   @if ($permissao->unidade_id == $unidade->id)
							    <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroCotacoes', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
							   @endif
							  @endif
							 @endforeach
							@endif
						</h2>
					</div>

					@if(($unidade->id > 1) && ($unidade->id <= 10)) <div id="collapseTwo" class="collapse multi-collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
						<div class="card-body">
							<p>
								<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Processos de Compra</a>
								<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Processos de Contratação de Terceiros</a>
							</p>
							<div class="collapse border-0" id="multiCollapseExample1">
								<div class="card card-body border-0">
									<div class="container">
										<p>
											<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">Síntese: Mapa do Sistema de Síntese</a>
											<a class="btn btn-success" href="{{route('visualizarOrdemCompra', $unidade->id)}}" role="button">Demais Processos</a>
										</p>
										<div class="collapse border-0" id="multiCollapseExample3">
											<div class="card card-body border-0">
												<div class="container">
													@foreach ($cotacoes as $cotacaoFiles)
													@if ($cotacaoFiles->proccess_name == 'MAPA DE COTAÇÕES')
													<table class="table table-sm table-success">
														<thead class="bg-success">
															<th scope="col">Título</th>
															<th scope="col">Arquivo</th>
														</thead>
														<tbody>
															<th> {{ $cotacaoFiles->proccess_name }} </th>
															<th> <a target="_blank" href="{{$cotacaoFiles->file_path}}"  style="font-size: 12px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a> </th>
														</tbody>
													</table>
													@endif
													@endforeach
													<table class="table table-sm table-success">
														<tr>
															<th> <a target="_blank" href="{{asset('storage/Passo a Passo Mapa de Cotação.pdf')}}"  style="font-size: 12px; padding: 0px; margin-left: 00px">Passo a Passo para Visualizar Mapa de Cotações <img src="{{asset('img/pdf.png')}}" width="40px" height="40px" /></a> </th>
														</tr>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="collapse border-0" id="multiCollapseExample2">
								<div class="card card-body border-0">
								<div class="table-responsive">
										<table class="table table-sm table-bordered table-success">
											<thead class="bg-success">
												<tr align="center">
													<th width="200px">Processo</th>
													<th width="80px">Mês/Ano</th>
													<th width="250px">Arquivos</th>
												</tr>
											</thead>
											<tbody>
												<?php $marcador = ''; ?>
												@foreach ($cotacoes as $cotacao)
												@if ($cotacao->proccess_name !== 'MAPA DE COTAÇÕES')
												@if ($cotacao->proccess_name !== $marcador)
												<tr>
													<td style="vertical-align: middle; font-size:14px">

														<strong>{{ $cotacao->proccess_name }}</strong>

													</td>
													<td align="center" style="vertical-align: middle; font-size:14px">
														<div class="d-flex flex-column">
															<strong><?php
																	echo $cotacao->mes == 1 ? "Janeiro" : ($cotacao->mes == 2 ? "Fevereiro" : ($cotacao->mes == 3 ? "Março" : ($cotacao->mes == 4 ? "Abril" : ($cotacao->mes == 5 ? "Maio" : ($cotacao->mes == 6 ? "Junho" : ($cotacao->mes == 7 ? "Julho" : ($cotacao->mes == 8 ? "Agosto" : ($cotacao->mes == 9 ? "Setembro" : ($cotacao->mes == 10 ? "Outubro" : ($cotacao->mes == 11 ? "Novembro" : ($cotacao->mes == 12 ? "Dezembro" : "")))))))))));
																	?></strong>
															<strong>
															    @if($cotacao->ano !== 0)
																{{ $cotacao->ano }}
																@endif
															</strong>
														</div>
													</td>
													<td>
														<div class="d-flex flex-column" style="text-align: left;" >
															@foreach ($cotacoes as $cotacaoArqs)
															 @if ($cotacao->proccess_name == $cotacaoArqs->proccess_name)
															  <div class="d-inline-flex m-1">
																<a target="_blank" href="<?php if (stripos($cotacaoArqs->file_path,'http') === false) {
                                                                       echo asset('storage/') . '/' . $cotacaoArqs->file_path;
                                                                    } else {
                                                                        echo $cotacaoArqs->file_path;
                                                                    }
                                                                ?>" class="border-bottom border-success" style="font-size: 12px; padding: 0px; margin-left: 00px">
                                                                <?php if($cotacaoArqs->id >= 168){
                                                                        echo substr($cotacaoArqs->file_name, 6 ,300);
                                                                      } else{
                                                                        echo $cotacaoArqs->file_name;
                                                                      } 
                                                                ?>
                                                                    <i style="color:#28a745" class="fas fa-download"></i>
                                                                </a>
															  </div>
															 @endif
															@endforeach
														</div>
													</td>
												</tr>
												@endif
												<?php $marcador = $cotacao->proccess_name; ?>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
				</div>
				@elseif($unidade->id == 8)
				<div id="collapseTwo" class="collapse multi-collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					<div class="card-body">
						<p>
							<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Processos de Compra</a>
						</p>
						<div class="collapse border-0" id="multiCollapseExample1">
							<div class="card card-body border-0">
								<div class="container">
									<p>
										<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Mapa de Síntese</a>
										<a class="btn btn-success" href="{{route('visualizarOrdemCompra', $unidade->id)}}" role="button">Demais Processos</a>
									</p>
								</div>
							</div>
						</div>
						<div class="collapse border-0" id="multiCollapseExample2">
							<div class="card card-body border-0">
								<div class="container">
									@foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
									@if ($cotacao == 'MAPA DE COTAÇÕES')
									<table class="table table-sm table-success">
										<thead>
											<tr>
												<th scope="col" style="width: 400px">Título</th>
												<th scope="col" style="width: 200px">Download</th>
											</tr>
										</thead>
										<tbody>
											<th> <a style="font-size: 15px; color: #28a745" class="btn" data-toggle="collapse" role="button" aria-expanded="false">
													<strong>{{$cotacao}}</strong>
												</a>
											</th>
											<th>
												@foreach ($cotacoes as $cotacaoFiles)
												@if ($cotacaoFiles->proccess_name == $cotacao)
												<a target="_blank" href="{{$cotacaoFiles->file_path}}" alt="{{$cotacaoFiles->file_path}}" class="list-group-item list-group-item-action" style="font-size: 12px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a>
												@endif
												@endforeach
											</th>
										</tbody>
									</table>
									@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
				@endif
			</div>
			<!-- AQUISIÇõES -->
			@if($unidade->id == 8)
			<div class="card">
				<div class="card-header" id="headingFive">
					<h2 class="mb-0">
						<a class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
							<strong>Aquisições Operação COVID-19</strong>
						</a>
						@if(Auth::check())
						@foreach ($permissao_users as $permissao)
						@if(($permissao->permissao_id == 10) && ($permissao->user_id == Auth::user()->id))
						@if ($permissao->unidade_id == $unidade->id)
						<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroCotacoes', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
						@endif
						@endif
						@endforeach
						@endif
					</h2>
				</div>
				<div id="collapseFive" class="collapse multi-collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
					<div class="card-body">
						<p>
							<a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample8" role="button" aria-expanded="false" aria-controls="multiCollapseExample8">Aquisições</a>
						</p>
						<div class="collapse border-0" id="multiCollapseExample8">
							<div class="card card-body border-0">
								<div class="container">
									@foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
									@if ($cotacao !== 'MAPA DE COTAÇÕES')
									<table class="table table-sm table-success">
										<thead>
											<tr>
												<th scope="col" style="width: 400px">Título</th>
												<th scope="col" style="width: 200px">Download</th>
											</tr>
										</thead>
										<tbody>
											<th> <a style="font-size: 15px; color: #28a745" class="btn" data-toggle="collapse" role="button" aria-expanded="false">
													<strong>{{$cotacao}}</strong>
												</a>
											</th>
											<th>
												@foreach ($cotacoes as $cotacaoFiles)
												@if ($cotacaoFiles->proccess_name == $cotacao)
												<a target="_blank" href="{{asset('../storage')}}/{{$cotacaoFiles->file_path}}" class="list-group-item list-group-item-action" style="font-size: 12px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="fas fa-download"></i></a>
												@endif
												@endforeach
											</th>
										</tbody>
									</table>
									@endif
									@endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endif

		<!-- CONTRATOS -->
		<div class="card">
			<div class="card-header" id="headingThree">
				<h2 class="mb-0">
					<a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<strong>Contratos</strong>
					</a>
					@if(Auth::check())
					 @foreach ($permissao_users as $permissao)
					  @if(($permissao->permissao_id == 11) && ($permissao->user_id == Auth::user()->id))
					   @if ($permissao->unidade_id == $unidade->id)
					    <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('contratacaoCadastro', $unidade->id)}}"> Alterar <i class="fas fa-edit"></i></a>
					   @endif
					  @endif
					 @endforeach
					@endif
					
					@if(Auth::check())
					 @foreach ($permissao_users as $permissao)
					  @if(($permissao->permissao_id == 25) && ($permissao->user_id == Auth::user()->id))
					   @if ($permissao->unidade_id == $unidade->id)
					    <a class="btn btn-success btn-sm" style="color: white;" href="{{route('paginaContratacaoServicos',$unidade->id)}}"> Processos <i class="bi bi-megaphone"></i></a>
					   @endif
					  @endif
				 	 @endforeach
					@endif
				</h2>
			</div>
			<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				<div class="card-body">
					<p>
						<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obras" role="button" aria-expanded="false" aria-controls="collapseExample">
							OBRAS <i class="fas fa-hard-hat"></i>
						</a>
						@if(Auth::check())
						<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('novoJS', array($unidade->id, 2))}}" > Justificativa <i class="fas fa-edit"></i></a>   
						@endif
					</p>
					<div class="collapse border-0" id="obras">
					    @if(isset($ultimaAtualizaObras))
						
						<label>
						    @if(isset($m))
						        Não há serviços de obras contratados pela unidade.
						    @endif
						</label>
						
						<p class="card-text"><small class="text-muted">Última atualização
								{{ date('d/m/Y', strtotime($ultimaAtualizaObras)) }}</small></p>
						@else 
						<p class="card-text"><small class="text-muted">Última atualização
								{{ date('d/m/Y', strtotime($contratos->max('updated_at'))) }}</small></p>
						@endif
						@if($unidade->id != 8) 
						   @foreach($justificativaO as $js)
						   <div class="border-0"> <center><b>JUSTIFICATIVA:</b> <br>
								<div class="card card-body border-0" style="background-color: #fafafa; width: 400px;">
									<div class="list-group" style="font-size: 15px;padding: 2px 2px;">
										<a href="{{asset('storage')}}/{{$js->caminho}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">{{$js->nome}} <i style="color:#65b345" class="fas fa-cloud-download-alt"></i></a>
										<br>Última Atualização: <b>{{ date('d/m/Y', strtotime($js->created_at)) }}</b>
									</div>
								</div></center>
							</div>
							@endforeach
						@endif
						<div class="card card-body border-0">
							<p>
								<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obrasPessoaFisica" role="button" aria-expanded="false" aria-controls="collapseExample">
									PESSOA FÍSICA <i class="fas fa-user-alt"></i>
								</a>
								<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#obrasPessoaJuridica" role="button" aria-expanded="false" aria-controls="collapseExample">
									PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
								</a>
							</p>
							<div class="collapse border-0" id="obrasPessoaFisica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm table-success">
											<thead class="bg-success">
												<tr>
													<th scope="col">CPF</th>
													<th scope="col">Empresa</th>
													<th scope="col">Objeto</th>
													<th scope="col">Opções</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($contratos as $contrato)
												 @if ($contrato->tipo_contrato === 'OBRAS' && $contrato->tipo_pessoa === 'PESSOA FÍSICA')
												  <tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td>
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">1º Contrato</a>
															<?php $idC = 1; $idR = 0; ?>
															<?php $aditivoVincula = 1; ?>
															@foreach($aditivos as $aditivo)
															 @if($aditivo->contrato_id == $contrato->ID)
															  @if($aditivo->opcao == 1)
															   <?php $id += 1;
															    if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
																  $id = 1;
															    }
															   ?>
															   <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo ({{ $aditivo->vinculado }})</a></strong>
															   <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1) ?>
															  @elseif($aditivo->opcao == 2)
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato ({{ $aditivo->vinculado }})</a></strong>
															  @elseif($aditivo->opcao == 3)  <?php $idR = $idR + 1; ?>
															  	<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idR }}º Rerratificação ({{ $aditivo->vinculado }})</a></strong>
															  @else <?php $idC += 1; ?>
															   <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idC }}º Contrato</a></strong>
															  @endif
															 @endif
															@endforeach
														</div>
													</td>
												  </tr>
												  @endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="collapse border-0" id="obrasPessoaJuridica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm table-success">
											<thead class="bg-success">
												<tr>
													<th scope="col">CNPJ</th>
													<th scope="col">Empresa</th>
													<th scope="col">Objeto</th>
													<th scope="col">Opções</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($contratos as $contrato)
												@if ($contrato->tipo_contrato == 'OBRAS' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td>
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Visualizar
														</a> <?php $id = 0; $idR = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">1º Contrato</a>
															<?php $idC = 1; ?>
															<?php $aditivoVincula = 1; ?>
															 @foreach($aditivos as $aditivo)
															  @if($aditivo->contrato_id == $contrato->ID)
															   @if($aditivo->opcao == 1)
															    <?php $id += 1;
            												      if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) { $id = 1;} ?>
        														    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo ({{ $aditivo->vinculado }})</a></strong>
        														    <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1) ?>
        													   @elseif($aditivo->opcao == 2)
            													 <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato ({{ $aditivo->vinculado }})</a></strong>
            												   @elseif($aditivo->opcao == 3)  <?php $idR = $idR + 1; ?>
															   	 <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idR }}º Rerratificação ({{ $aditivo->vinculado }})</a></strong>
															   @else <?php $idC += 1; ?>
            													 <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idC }}º Contrato</a></strong>
            												   @endif
															  @endif
															@endforeach
														</div>
													</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p>
						<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicos" role="button" aria-expanded="false" aria-controls="collapseExample">
							SERVIÇOS <i class="fas fa-tools"></i>
						</a>
					</p>
					<div class="collapse border-0" id="servicos">
						<div class="card card-body border-0">
							<p>
								<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicosPessoaFisica" role="button" aria-expanded="false" aria-controls="collapseExample">
									PESSOA FÍSICA <i class="fas fa-user-alt"></i>
								</a>
								<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#servicosPessoaJuridica" role="button" aria-expanded="false" aria-controls="collapseExample">
									PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
								</a>
							</p>
							<div class="collapse border-0" id="servicosPessoaFisica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm table-success">
											<thead class="bg-success">
												<tr>
													<th scope="col">CNPJ:</th>
													<th scope="col">Pessoa</th>
													<th scope="col">Serviço</th>
													<th scope="col">Opções</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($contratos as $contrato)
												@if ($contrato->tipo_contrato == 'SERVIÇOS' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td>
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">1º Contrato</a>
															<?php $idC = 1; $idR = 0; ?>
															<?php $aditivoVincula = 1; ?>
															@foreach($aditivos as $aditivo)
															 @if($aditivo->contrato_id == $contrato->ID)
															  @if($aditivo->opcao == 1)
															   <?php $id += 1;
															    if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
																  $id = 1;
															    }
															   ?>
															   <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo ({{ $aditivo->vinculado }})</a></strong>
															    <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1) ?>
															  @elseif($aditivo->opcao == 2)
															   <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato ({{ $aditivo->vinculado }})</a></strong>
															  @elseif($aditivo->opcao == 3)  <?php $idR = $idR + 1; ?>
															  	<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idR }}º Rerratificação ({{ $aditivo->vinculado }})</a></strong>
															  @else 
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idC }}º Contrato</a></strong>
															  @endif
															 @endif
															@endforeach
														</div>
													</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="collapse border-0" id="servicosPessoaJuridica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-hover table-sm table-success">
											<thead class="bg-success">
												<tr>
													<th scope="col">CNPJ</th>
													<th scope="col">Empresa</th>
													<th scope="col">Serviço</th>
													<th scope="col">Opções</th>
												</tr>
											</thead>
											<tbody>
											  @foreach ($contratos as $contrato)
											   @if ($contrato->tipo_contrato == 'SERVIÇOS' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
							                    <tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td>
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">1º Contrato @if($contrato->inativa == 1) (Inativo) @endif </a>
															<?php $idC = 1; $idR = 0; ?>
															<?php $aditivoVincula = 1; ?>
															@foreach($aditivos as $aditivo)
															 @if($aditivo->contrato_id == $contrato->ID)
															  @if($aditivo->opcao == 1)
															   <?php 
															    if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
																  $id = 0;
														 	    }
															   ?>
															    <?php $id += 1; ?>
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo ({{ $aditivo->vinculado }}) @if($aditivo->inativa == 1) (Inativo) @endif</a></strong>
															     <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1) ?>
															  @elseif($aditivo->opcao == 2)
															     <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato ({{ $aditivo->vinculado }}) @if($aditivo->inativa == 1) (Inativo) @endif</a></strong>
															  @elseif($aditivo->opcao == 3)  <?php $idR = $idR + 1; ?>
																<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idR }}º Rerratificação ({{ $aditivo->vinculado }}) @if($aditivo->inativa == 1) (Inativo) @endif</a></strong>
															  @else 
														         <?php $idC = $idC + 1; ?>
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idC }}º Contrato @if($aditivo->inativa == 1) (Inativo) @endif</a></strong>
															  @endif
															 @endif
															@endforeach
														</div>
													</td>
												</tr>
											   @endif
											  @endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<p>
						<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicao" role="button" aria-expanded="false" aria-controls="collapseExample">
							AQUISIÇÃO DE BENS <i class="fas fa-people-carry"></i>
						</a>
						@if(Auth::check())
						<a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('novoJS', array($unidade->id, 3))}}"> Justificativa <i class="fas fa-edit"></i></a>   
						@endif
					</p>
					<div class="collapse border-0" id="aquisicao">
					    @if($unidade->id != 8) 
						   @foreach($justificativaA as $js)
						   <div class="border-0"> <center><b>JUSTIFICATIVA:</b> <br>
								<div class="card card-body border-0" style="background-color: #fafafa; width: 400px;">
									<div class="table table-success" style="font-size: 15px;padding: 2px 2px;">
										<a href="{{asset('storage')}}/{{$js->caminho}}" target="_blank" style="padding: 5px 5px;">{{$js->nome}} <i style="color:#65b345" class="fas fa-cloud-download-alt"></i></a>
										<br>Última Atualização: <b>{{ date('d/m/Y', strtotime($js->created_at)) }}</b>
									</div>
								</div></center>
							</div>
							@endforeach
						 @endif	
						<div class="card card-body border-0">
                            	@foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
								  @if ($cotacao == 'MAPA DE COTAÇÕES')
									@foreach ($cotacoes as $cotacaoFiles)
									  @if ($cotacaoFiles->proccess_name == $cotacao)
										<a target="_blank" href="{{$cotacaoFiles->file_path}}" alt="{{$cotacaoFiles->file_path}}" class="table table-success m-3" style="font-size: 15px; padding: 0px; margin-left: 00px">{{$cotacaoFiles->file_name}} <i style="color:#28a745" class="bi bi-globe2"></i> </a>
									  @endif
									@endforeach
								  @endif
								@endforeach
							<p>
							    <a target="_blank" href="{{asset('storage/Passo a Passo Mapa de Cotação.pdf')}}" class="table table-success d-block m-3" style="font-size: 15px; padding: 0px; margin-left: 00px;color: black;">Passo a Passo para Visualizar Mapa de Cotações <img src="{{asset('img/pdf.png')}}" width="40px" height="40px" /></a>
							    
								<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicaoPessoaFisica" role="button" aria-expanded="false" aria-controls="collapseExample">
									PESSOA FÍSICA <i class="fas fa-user-alt"></i>
								</a>
								<a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#aquisicaoPessoaJuridica" role="button" aria-expanded="false" aria-controls="collapseExample">
									PESSOA JURÍDICA <i class="fas fa-user-tie"></i>
								</a>
							</p>
							<div class="collapse border-0" id="aquisicaoPessoaFisica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm table-success">
											<thead class="bg-success">
												<tr>
													<th scope="col">CPF</th>
													<th scope="col">Empresa</th>
													<th scope="col">Objeto</th>
													<th scope="col">Opções</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($contratos as $contrato)
												@if ($contrato->tipo_contrato == 'AQUISIÇÃO' && $contrato->tipo_pessoa == 'PESSOA FÍSICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td>
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">1º Contrato</a>
															<?php $idC = 1; $idR = 0; ?>
															<?php $aditivoVincula = 1; ?>
															@foreach($aditivos as $aditivo)
															 @if($aditivo->contrato_id == $contrato->ID)
														 	  @if($aditivo->opcao == 1)
															   <?php $id += 1;
															    if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
																  $id = 1;
															    }
															   ?>
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo ({{ $aditivo->vinculado }})</a></strong>
														  	    <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1) ?>
															  @elseif($aditivo->opcao == 2)
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato ({{ $aditivo->vinculado }})</a></strong>
															  @elseif($aditivo->opcao == 3)  <?php $idR = $idR + 1; ?>
															   	<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idR }}º Rerratificação ({{ $aditivo->vinculado }})</a></strong>
															  @else <?php $idC += 1; ?>
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idC }}º Contrato</a></strong>
														 	  @endif
															 @endif
															@endforeach
														</div>
													</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="collapse border-0" id="aquisicaoPessoaJuridica">
								<div class="card card-body border-0">
									<div class="container">
										<table class="table table-sm table-success">
											<thead class="bg-success">
												<tr>
													<th scope="col">CNPJ</th>
													<th scope="col">Empresa</th>
													<th scope="col">Objeto</th>
													<th scope="col">Opções</th>
												</tr>
											</thead>
											<tbody>
												@foreach ($contratos as $contrato)
												@if ($contrato->tipo_contrato == 'AQUISIÇÃO' && $contrato->tipo_pessoa == 'PESSOA JURÍDICA')
												<tr>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->cnpj_cpf}}">{{$contrato->cnpj_cpf}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->prestador}}">{{$contrato->prestador}}</td>
													<td class="text-truncate" style="max-width: 100px;" title="{{$contrato->objeto}}">{{$contrato->objeto}}</td>
													<td>
														<a class="badge badge-pill badge-primary dropdown-toggle" type="button" href="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Visualizar
														</a> <?php $id = 0; ?>
														<div id="div" class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="font-size: 12px;">
															<a id="div" class="dropdown-item" href="{{asset('storage/')}}/{{$contrato->file_path}}" target="_blank">1º Contrato</a>
															<?php $idC = 1; $idR = 0; ?>
															<?php $aditivoVincula = 1; ?>
															@foreach($aditivos as $aditivo)
															 @if($aditivo->contrato_id == $contrato->ID)
														 	  @if($aditivo->opcao == 1)
															   <?php $id += 1;
															    if (substr($aditivo->vinculado, 0, 1) != $aditivoVincula) {
																  $id = 1;
															    }
															   ?>
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{$id}}º Aditivo ({{ $aditivo->vinculado }})</a></strong>
															    <?php $aditivoVincula = substr($aditivo->vinculado, 0, 1) ?>
															  @elseif($aditivo->opcao == 2)
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">Distrato ({{ $aditivo->vinculado }})</a></strong>
															  @elseif($aditivo->opcao == 3)  <?php $idR = $idR + 1; ?>
															  	<strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idR }}º Rerratificação ({{ $aditivo->vinculado }})</a></strong>
															  @else <?php $idC += 1; ?>
															    <strong><a id="div" class="dropdown-item" href="{{asset('storage')}}/{{$aditivo->file_path}}" target="_blank">{{ $idC }}º Contrato</a></strong>
															  @endif
															 @endif
															@endforeach
														</div>
													</td>
												</tr>
												@endif
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
@endsection