@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid" style="margin-top: 25px;">
	<div class="row" style="margin-bottom: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CANAL DE DENÚNCIAS <i class="fas fa-globe"></i></h5>
		</div>
	</div> <br>
	<div class="row d-flex justify-content-center">

		<div class="text-center">
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item">
        			<a class="nav-link active" id="pills-denuncias-tab" data-toggle="pill" href="#pills-denuncias" role="tab" aria-controls="pills-home" aria-selected="true"><b>Canal De Denúncias</b></a>
        	    </li>
			</ul>
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-denuncias" role="tabpanel" aria-labelledby="pills-denuncias-tab">
					<div class="d-sm-block justify-content-sm-center table-success rounded mt-4 ">
						<div class="d-flex flex-column justify-content-center">
							<div class="d-flex flex-column justify-content-center">
								<div class="d-sm-inline-flex text-center justify-content-sm-center">
									<div class="d-flex flex-column justify-content-center p-1 text-center">
											<div class="row">
												<div class="col">
													<div class="d-flex flex-column" style="font-size:15px;">
														<label><center><img src="{{ asset('img/denuncias.jpg') }}" style="width:400px; margin-top: 100px;" /><center></label> <br>
														<a class="btn btn-success btn-sm" style="color: #FFFFFF;" href="https://canaldedenuncia.com.br/hcpgestao/#home"> <b>Denunciar</b> <i class="fas fa-check"></i> </a>
													</div>
												</div>
												<div class="col">
													<div class="d-flex flex-column" style="font-size:15px;">
														<label><p align="justify"><font color="black"><b>"O canal de denúncia do HCP Gestão é um canal exclusivo e que garante uma comunicação segura
																e, se desejada, anônima, de condutas que violem as leis vigentes, os princípios éticos, as
																normas, políticas e padrões de conduta da nossa Organização.</b></font></p></label>
														<label><p align="justify"><font color="black"><b>O canal pode ser utilizado por nossos colaboradores e por pessoas externas à companhia, 
															tais como clientes, fornecedores, parceiros de negócios, entre outros, que acreditem que 
															ocorreu ou possa estar ocorrendo alguma violação ao Código de Conduta do HCP GESTÃO.</b></font></p></label>
														<label><p align="justify"><font color="black"><b>As informações registradas pelo Canal de Denúncia serão recebidas por uma empresa 
																independente e especializada, a Aliant, assegurando sigilo absoluto e o tratamento 
																adequado de cada situação pelo Comitê de Ética | HCP GESTÃO, sem conflitos de 
																interesses."</b></font></p></label>
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
</div>
@endsection