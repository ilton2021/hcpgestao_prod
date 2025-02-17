@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RELATÓRIO FINANCEIRO E DE EXECUÇÃO ANUAL</h3>
			<div class="d-flex justify-content-around p-2">
				<a href="{{route('transparenciaFinanReports', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
				<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoRF', $unidade->id)}}"> <b>Novo</b> <i class="fas fa-check"></i></a>
			</div>
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
		<div class="col-md-12 col-sm-12">
			<div class="accordion" id="accordionExample">
				@foreach ($relatorioFinanceiro->pluck('ano')->unique() as $ano)
				<div class="card border-bottom" style="margin-bottom: 5px;">
					<a class="btn text-decoration-none" type="button" data-toggle="collapse" href="#{{$ano}}Competência" aria-expanded="true" aria-controls="{{$ano}}Competência">
						<strong>Competência {{$ano}}</strong> <i style="color:#65b345;" class="fas fa-search-dollar"></i>
					</a>
					<div id="{{$ano}}Competência" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							@foreach ($relatorioFinanceiro as $relF)
							@if ($ano === $relF->ano)
							<div class="d-flex flex-column justify-content-center justify-content-md-between" id="headingOne">
								<div class="d-sm-inline-flex text-center justify-content-between align-items-center">
									<div class="p-2">
										{{$relF->title}}
									</div>
									<div class="d-inline-flex justify-content-center justify-content-sm-between flex-wrap align-items-center">
										<div class="p-2">
											<a class="btn btn-success" style="color: #FFFFFF; font-size:12px" href="{{asset('storage')}}/{{$relF->file_path}}" target="_blank"><b>Download</b> <i class="bi bi-download"></i></a>
										</div>
										<div class="p-2">
										   @if($relF->status_financeiro == 0)
										     <a class="btn btn-success" style="font-size:12px" href="{{route('telaInativarRF', array($unidade->id, $relF->id))}}">  <i class="fas fa-times-circle"></i></a>
										   @else
										     <a class="btn btn-warning" style="font-size:12px" href="{{route('telaInativarRF', array($unidade->id, $relF->id))}}">  <i class="fas fa-times-circle"></i></a>
										   @endif
										</div>
									</div>
								</div>
							</div>
							@endif
							@endforeach
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
@endsection