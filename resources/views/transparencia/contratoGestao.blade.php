@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está｡ em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CONTRATOS DE GESTÃO / ADITIVOS</h3>
		</div>
	</div>
		<div class="row">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12">
			<div id="accordion">
				@foreach($unidades as $und)
				@if($unidade->id == $und->id || $unidade->id == 1)
				@if($und->id > 1)
				<div class="card mt-1">
					<div class="card-header d-flex flex-column justify-content-center justify-content-md-between " id="headingOne">
						<div class="d-sm-inline-flex text-center justify-content-between">
							<div class="mt-2" style="cursor: pointer;">
								<a class="text-dark no-underline" style="font-size:15px" data-toggle="collapse" data-target="#<?php echo $und->id; ?>" aria-expanded="true" aria-controls="2">
									<strong>{{$und->name}}</strong>
								</a>
							</div>
							@if(Auth::check())
							@foreach ($permissao_users as $permissao)
							@if(($permissao->permissao_id == 5) && ($permissao->user_id == Auth::user()->id))
							@if ($permissao->unidade_id == $und->id || $permissao->unidade_id == 1)
							<div class="p-1">
								<a href="{{route('cadastroCG', $und->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <b>Alterar</b> <i class="fas fa-edit"></i> </a></p>
							</div>
							@endif
							@endif
							@endforeach
							@endif
						</div>
					</div>

					<div id="<?php echo $und->id; ?>" class="collapse {{$unidade->id == $und->id? 'show' : ''}}" aria-labelledby="headingOne" data-parent="#accordion">
						@foreach($contratos as $contrato)
						@if($contrato->unidade_id == $und->id)
						<div class="d-flex flex-column justify-content-center justify-content-md-between border-bottom" id="headingOne">
							<div class="d-sm-inline-flex text-center justify-content-center">
								<div class="d-flex align-items-center p-2">
									<a class="text-dark no-underline" target="_blank" href="{{asset('storage/')}}/{{$contrato->path_file}}"><strong>{{$contrato->title}} <i style="color: #28a745;" class="fas fa-download"></i></strong></a>
								</div>
							</div>
						</div>
						@endif
						@endforeach
					</div>

				</div>
				@endif
				@endif
				@endforeach
			</div>
		</div>
		<div class="col-md-2 col-sm-0"></div>
	</div>
</div>
@endsection