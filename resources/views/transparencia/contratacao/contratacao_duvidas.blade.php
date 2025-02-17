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
				<div class="card">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<a class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								<strong>Dúvidas - Contratos</strong>
							</a>
							<a href="{{ route('contratacaoCadastro', [$unidade->id]) }}"
                                        class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
					    </h2>
					</div>
					<div>
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/novoContrato.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Cadastrar Novo Contrato</strong></h6></li>
								</div>
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/alterarContratos.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Alterar Contratos</strong></h6></li>
								</div>
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/alterarAditivo.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Alterar Aditivos</strong></h6></li>
								</div>
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/alterarGestor.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Alterar Gestor</strong></h6></li>
								</div>
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/excluirContratos.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Excluir Contratos</strong></h6></li>
								</div>
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/status.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Status</strong></h6></li>
								</div>
								<div class="col-12">
									<li class="list-group-item border-0" style="font-size: 15px;"><a href="{{asset('storage')}}/{{('duvidas/telaDuvidas.pdf')}}" target="_blank"><img src="{{asset('img/pdf.png')}}" alt="" width="40"></a><h6 class="text-success"><strong>Dúvidas</strong></h6></li>
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