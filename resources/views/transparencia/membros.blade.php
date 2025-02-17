@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">MEMBROS DIRIGENTES</h5>
		</div>
	</div>	
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12">

			<div class="accordion" id="accordionExample">
				<div class="card">
				    <div class="card-header d-flex flex-wrap justify-content-center justify-content-md-between" id="headingOne">
				        <div>
    						<h5 class="mb-0">
    							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
    								ASSOCIADOS <i class="far fa-list-alt"></i>
    							</a>
    						</h5>
						</div>
						<div>
    						<h5 class="mb-0">
    							<a href="{{route('exportAssociados')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
    							@if(Auth::check())
    							 @foreach ($permissao_users as $permissao)
    							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
    							   @if ($permissao->unidade_id == $unidade->id)
    								 <a class="btn btn-info btn-sm" href="{{route('listarAS', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
    							   @endif	
    							  @endif 
    							 @endforeach 
    							@endif
    						</h5>
						</div>
					</div>
					
					<div id="collapseOne" class="collapse {{$escolha == 'Associados'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
					    
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Associados Efetivos</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<div class="border rounded">
										<tr>
											<td colspan="3" class="text-left border-0" style="font-size: 12px;"><strong>Associados</strong></td>
										</tr>
										<div class="d-sm-block table-success rounded">
											<div class="d-flex flex-column">
											@foreach($associados as $associado)
												<div class="d-flex flex-column text-center border-bottom border-success">
													<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
														<div class="d-flex flex-column p-2">
															<div><label><i style="font-size:16px;" class="bi bi-person-circle"></i> Nome: {{$associado->name}}</label></div>
														</div>
													</div>
												</div>
											@endforeach
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
				    <div class="card-header d-flex flex-wrap justify-content-center justify-content-md-between" id="headingOne">
				        <div>
    						<h5 class="mb-0">
    							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
    								CONSELHO DE ADMINISTRAÇÃO <i class="far fa-list-alt"></i>
    							</a>
    						</h5>
						</div>
						<div>
    						<h5 class="mb-0">
    							<a href="{{route('exportConselhoAdm')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
    							@if(Auth::check())	
    							 @foreach ($permissao_users as $permissao)
    							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
    							   @if ($permissao->unidade_id == $unidade->id)
    								<a class="btn btn-info btn-sm" href="{{route('listarCA', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
    							   @endif
    							  @endif 
    							 @endforeach 
    							@endif
    						</h5>
						</div>
					</div>
					<div id="collapseTwo" class="collapse {{$escolha == 'Conselho administrativo'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Conselho de Administração</strong></h5></div>
							<div class="row">
								<div class="col-md-2  col-sm-0"></div>
								<div class="col-md-8  col-sm-12">
									<div class="d-sm-block table-success rounded">
										<div class="d-flex flex-column">
										@foreach($conselhoAdms as $conselhoAdm)
											<div class="d-flex flex-column text-center border-bottom border-success">
												<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
													<div class="d-flex flex-column p-2">
														<div><label><i style="font-size:15px;" class="bi bi-person-circle"></i><b> {{$conselhoAdm->cargo}}</b></label></div>
														<div><label><b>Nome:</b> {{$conselhoAdm->name}}</label></div>
													</div>
												</div>
											</div>
										@endforeach
										</div>
									</div>
								</div>
								<div class="col-md-2  col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
				    <div class="card-header d-flex flex-wrap justify-content-center justify-content-md-between" id="headingOne">
				        <div>
    						<h5 class="mb-0">
    							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
    								CONSELHO FISCAL <i class="far fa-list-alt"></i>
    							</a>
    						</h5>
						</div>
						<div>
    						<h5 class="mb-0">
    							<a href="{{route('exportConselhoFisc')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
    							@if(Auth::check())	
    							 @foreach ($permissao_users as $permissao)
    							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
    							   @if ($permissao->unidade_id == $unidade->id)
    								<a class="btn btn-info btn-sm" href="{{route('listarCF', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
    							   @endif
    							  @endif 
    							 @endforeach 
    							@endif
    						</h5>	
						</div>
					</div>
					<div id="collapseThree" class="collapse {{$escolha == 'Conselho fiscal'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Conselho Fiscal</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<div class="border rounded">
										<tr>
											<td colspan="3" class="text-left border-0" style="font-size: 12px;"><strong>Titulares</strong></td>
										</tr>
										@foreach($conselhoFiscs as $conselhoFisc)
											@if($conselhoFisc->level === 'Titular')
											<div class="d-sm-block table-success rounded">
												<div class="d-flex flex-column">
													<div class="d-flex flex-column text-center border-bottom border-success">
														<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
															<div class="d-flex flex-column p-2">
																<div><label><i style="font-size:15px;" class="bi bi-person-circle"></i><b> {{$conselhoFisc->name}}</b></label></div>
																<input type="hidden" id="txtTitulares" name="txtTitulares" value="<?php echo $conselhoFisc->name; ?>" />
															</div>
														</div>
													</div>
												</div>
											</div>
											@endif
										@endforeach
									</div>
									<br>
									<div class="border rounded">
										<tr>
											<td colspan="3" class="text-left border-0" style="font-size: 12px;"><strong>Suplentes</strong></td>
										</tr>
										@foreach($conselhoFiscs as $conselhoFisc)
											@if($conselhoFisc->level === 'Suplente')
											<div class="d-sm-block table-success rounded">
												<div class="d-flex flex-column">
													<div class="d-flex flex-column text-center border-bottom border-success">
														<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
															<div class="d-flex flex-column p-2">
																<div><label><i style="font-size:15px;" class="bi bi-person-circle"></i><b> {{$conselhoFisc->name}}</b></label></div>
															</div>
														</div>
													</div>
												</div>
											</div>
											@endif
										@endforeach
									</div>
								</div>
								<div class="col-md-2 col-sm-0"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card">
				    <div class="card-header d-flex flex-wrap justify-content-center justify-content-md-between" id="headingOne">
				        <div>
    						<h5 class="mb-0">
    							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
    								SUPERINTENDENTES <i class="far fa-list-alt"></i>
    							</a>
    						</h5>
						</div>
						<div>
    						<h5 class="mb-0">
    							<a href="{{route('exportSuperintendente')}}" class="btn btn-success btn-sm"><i class="fas fa-file-csv" style="margin-right: 5px;"></i>Download</a>
    							@if(Auth::check())
    							 @foreach ($permissao_users as $permissao)
    							  @if(($permissao->permissao_id == 13) && ($permissao->user_id == Auth::user()->id))
    							   
    								<a class="btn btn-info btn-sm" href="{{route('listarSUP', $unidade->id)}}" >Alterar <i class="fas fa-edit"></i></a>
    							  
    							  @endif
    							 @endforeach		
    							@endif
    						</h5>
						</div>
					</div>
					<div id="collapseFour" class="collapse {{$escolha == 'Superintendentes'? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Superintendentes</strong></h5></div>
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-8 col-sm-12">
									<div class="border">
                						<div style="margin-top: 5px; margin-bottom: 5px; font-size: 16px;"><strong>Suplentes</strong></div>
                							@foreach($superintendentes as $superintendente)
                								<div class="d-sm-block table-success rounded">
                									<div class="d-flex flex-column">
                										<div class="d-flex flex-column text-center border-bottom border-success">
                											<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
                												<div class="d-flex flex-column p-2">
                													<div><label><i style="font-size:15px;" class="bi bi-person-circle"></i><b> {{$superintendente->cargo}}</b></label></div>
                													<div><label><b>Nome:</b> {{$superintendente->name}}</label></div>
                												</div>
                											</div>
                										</div>
                									</div>
                								</div>
                							@endforeach
                					</div>
								</div>
								<div class="col-md-2 col-sm-0"></div>
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