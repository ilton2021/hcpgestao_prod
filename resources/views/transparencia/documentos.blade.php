@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="container-fluid" >
	<div class="row mt-3">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">DOCUMENTAÇÃO DE REGULARIDADE</h5>
		</div>
		
		@if(Auth::check())
		@foreach ($permissao_users as $permissao)
		@if(($permissao->permissao_id == 4) && ($permissao->user_id == Auth::user()->id))
		@if ($permissao->unidade_id == $unidade->id)
		<div class="col-md-12 mt-1 text-center">
			<p><a href="{{route('cadastroDR', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <b>Alterar</b> <i class="fas fa-edit"></i> </a></p>
		</div>
		@endif
		@endif
		@endforeach
		@endif
	
	</div>
	<div class="row" style="margin-top: 0px;">
		<div class="col-md-1"></div>
		<div class="col-md-10 text-center">
			@foreach($types as $type)
			<div class="accordion border-0" id="accordionExample">
				<div class="card">
					<div class="card-header border-0 p-2" id="headingOne" style="padding: 0px;">
						<h6>
							<a class="text-red no-underline text-wrap" type="button" data-toggle="collapse" data-target="#{{$type->id}}" aria-expanded="true" aria-controls="{{$type->id}}" style="cursor: pointer;">
								{{$type->type_name}}
							</a>
						</h6>
					</div>
					<div id="{{$type->id}}" class="collapse {{$escolha == $type->type_name? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body d-flex flex-column justify-content-center justify-content-md-between">
							  <div class="d-sm-inline-flex text-sm-center flex-wrap justify-content-between">
								<div class="col-md-12 mr-2">
									@if($type->id == 1)
									<table class="table table-success table-sm border border-rounded">
										@foreach($documents as $docs)
										@if($docs->type_id == $type->id)
										<center>
											<tr>
												<td width="100%;">{{$docs->name}}</td>
												<td><i class="fas fa-arrow-right"></i></td>
												<td><a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a></td>
											</tr>
										</center>
										@endif
										@endforeach
									</table>
									<table class="table table-success table-sm border border-rounded">
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">Passo a Passo</button>
											<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
											  <div class="modal-dialog modal-lg">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">CNPJ:</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<img src="{{asset('img/novas/cnpj.png')}}" class="img-fluid" alt=""> <br>
													 <center>
													   <b>Passo a Passo:</b> <br>
														1) Digite o CNPJ da unidade no campo indicado; <br>
														2) Clique no Botão Sou Humano; <br>
														3) Por fim, clique no botão Consultar.
													 </center> 
												  </div>
												</div>
											  </div>
											</div>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://solucoes.receita.fazenda.gov.br/Servicos/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 2)
									<table class="table table-success table-sm border border-rounded">
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg2">Passo a Passo</button>
											<div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
											  <div class="modal-dialog modal-lg">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Fazenda Pública:</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<img src="{{asset('img/novas/regularidade_fiscal.png')}}" class="img-fluid" alt=""> <br>
													 <center>
													   <b>Passo a Passo:</b> <br>
													   1) Tipo de Documento: Selecione CNPJ; <br>
													   2) Digite o CNPJ da unidade; <br> 
													   3) Clique no botão Localizar; <br>
													   4) Clique no Botão Emitir; <br>
													   5) Clique no botão Visualizar/Imprimir Documento.
													 </center> 
												  </div>
												</div>
											  </div>
											</div>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://efisco.sefaz.pe.gov.br/sfi_trb_gcc/PREmitirCertidaoRegularidadeFiscal" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 3)
									<table class="table table-success table-sm border border-rounded">
									  <tr>
										<td><b>Visualizar</b></td>
										<td>
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg3">Passo a Passo</button>
											<div class="modal fade bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
											  <div class="modal-dialog modal-lg">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Seguraridade Social:</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<img src="{{asset('img/novas/seguraridade_social.png')}}" class="img-fluid" alt=""> <br>
													 <center>
													   <b>Passo a Passo:</b> <br>
													   1) Digite o CNPJ da unidade no campo indicado; <br>
													 </center> 
												  </div>
												</div>
											  </div>
											</div>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://solucoes.receita.fazenda.gov.br/Servicos/certidaointernet/PJ/Emitir" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 4)
									<table class="table table-success table-sm border border-rounded">
									  <tr>
										<td><b>Visualizar</b></td>
										<td> 
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg4">Passo a Passo</button>
											<div class="modal fade bd-example-modal-lg4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
											  <div class="modal-dialog modal-lg">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">FGTS:</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<img src="{{asset('img/novas/fgts.png')}}" class="img-fluid" alt=""> <br>
													 <center>
													   <b>Passo a Passo:</b> <br>
													   1) Tipo de Inscrição: Selecione a opção CNPJ; <br>
												   	   2) Digite o CNPJ da unidade no campo indicado; <br>
													   3) Não é para ser preenchido o campo UF; <br>
													   4) Digite os caracteres de confirmação; <br>
													   5) Clique no Botão Consultar.
													 </center> 
												  </div>
												</div>
											  </div>
											</div>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://consulta-crf.caixa.gov.br/consultacrf/pages/consultaEmpregador.jsf" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 5)
									<table class="table table-sm">
									  <tr>
										<td><b>Visualizar</b></td>
										<td> 
											<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg5">Passo a Passo</button>
											<div class="modal fade bd-example-modal-lg5" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
											  <div class="modal-dialog modal-lg">
												<div class="modal-content">
												  <div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Justiça do Trabalho:</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												  </div>
												  <div class="modal-body">
													<img src="{{asset('img/novas/justica_trabalho.png')}}" class="img-fluid" alt=""> <br>
													 <center>
													   <b>Passo a Passo:</b> <br>
													    1) Clique na opção Emitir Certidão; <br>
														2) Digite o CNPJ da unidade no campo indicado; <br>
														3) Valide o reCAPTCHA (não sou um robô); <br>
														4) Clique na opção Emitir Certidão.
													 </center> 
												  </div>
												</div>
											  </div>
											</div>
										</td>
									  </tr>
									  <tr>
										<td><b>Como Acessar:</b></td>
										<td><a class="btn btn-success btn-sm" href="https://www.tst.jus.br/web/guest/certidao" target="_blank">Clique aqui</a></td>
									  </tr>
									</table>
									@elseif($type->id == 6 || $type->id == 7 || $type->id == 8 || $type->id == 9)
									<table class="table table-success border border-rounded table-sm">
										@foreach($documents as $docs)
											@if($docs->type_id == $type->id)
												<center>
												
													<tr>
													<td width="100%;">{{$docs->name}}</td>
														<td><i class="fas fa-arrow-right"></i></td>
														<td><a href="{{asset('storage/')}}/{{$docs->path_file}}" target="_blank" class="badge badge-success">Download</a></td>
													</tr>
												
												</center>
											@endif
										@endforeach
									</table>
									@endif
								</div>
							  </div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-md-1"></div>
	</div>
</div>
  <script src="{{ asset('assets/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
@endsection