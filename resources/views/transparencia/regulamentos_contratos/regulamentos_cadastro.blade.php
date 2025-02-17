@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
  <div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">REGULAMENTOS - CONTRATAÇÃO</h3>
			<div class="d-flex justify-content-around p-2">
				<a href="{{route('transparenciaContratacao', array($unidade->id, 1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
				<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoRC', $unidade->id)}}"> Novo <i class="fas fa-check"></i></a>
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
		<div class="col-md-2 col-sm-0"></div>
		  <div class="col-md-8 col-sm-12">
			<div class="accordion" id="accordionExample">
				@foreach ($regulamentos as $reg)
					<div class="d-flex flex-column justify-content-center justify-content-md-between" id="headingOne">
						<div class="d-sm-inline-flex text-center justify-content-between align-items-center">
						  <div class="p-2">
							{{$reg->title}}
						  </div>
						  <div class="p-2">
							@if($reg->tipo == 1) {{ 'Manuais' }}
							@else {{ 'Instruções normativas' }}
							@endif
						  </div>
						  <div class="d-inline-flex justify-content-center justify-content-sm-between flex-wrap align-items-center">
							<div class="p-2">
								<a class="btn btn-success" style="color: #FFFFFF; font-size:12px" href="{{asset('storage')}}/{{$reg->caminho}}" target="_blank" >Download <i class="bi bi-download"></i></a>
							</div>
							<div class="p-2">
							    @if($reg->status == 0)
			  	     		 	    <a class="btn btn-success" style="color: #FFFFFF; font-size:12px" href="{{route('telaInativarRC', array($unidade->id, $reg->id))}}">  <i class="fas fa-times-circle"></i></a>
							    @else
								    <a class="btn btn-warning" style="color: #FFFFFF; font-size:12px" href="{{route('telaInativarRC', array($unidade->id, $reg->id))}}">  <i class="fas fa-times-circle"></i></a>
								@endif
							</div>
						   </div>
						</div>
					</div>
				@endforeach
			</div>
		</div>
	</div>
  </div>
</div>
@endsection