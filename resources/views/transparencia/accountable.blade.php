@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">DEMONSTRAÇÕES CONTÁBEIS E PARECERES</h3>
			@if(Auth::check())
			@foreach ($permissao_users as $permissao)
			@if(($permissao->permissao_id == 6) && ($permissao->user_id == Auth::user()->id))
			@if ($permissao->unidade_id == $unidade->id)
			<a href="{{route('cadastroDC', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <b>Alterar</b> <i class="fas fa-edit"></i> </a></li>
			@endif
			@endif
			@endforeach
			@endif
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12">
			<div class="accordion" id="accordionExample">
				@foreach ($demonstrativoContaveis->pluck('ano')->unique() as $ano)
				<div class="card border-bottom" style="margin-bottom: 5px;">
					<a class="btn text-decoration-none" style="word-wrap: break-word;white-space:normal !important;word-wrap: break-word; word-break: normal;" type="button" data-toggle="collapse" href="#{{$ano}}Competência" aria-expanded="true" aria-controls="{{$ano}}Competência">
						<strong>Competência {{$ano}}</strong> <i style="color:#65b345;" class="fas fa-search-dollar"></i>
					</a>
					<div id="{{$ano}}Competência" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body border-0">
							<div class="d-flex flex-column">
								@foreach ($demonstrativoContaveis as $demonstrativoContabel)
								@if ($ano === $demonstrativoContabel->ano)
								<div class="d-md-inline-flex justify-content-between table-success border-roundend border-bottom border-success align-items-center">
									<div class="p-2">
										<h6 style="font-size: 12px;"><b>{{$demonstrativoContabel->title}}</b></h6>
									</div>
									<div class="p-2 text-center">
										<a href="{{asset('storage/')}}/{{$demonstrativoContabel->file_path}}" target="_blank" class="badge badge-success"><b>Download</b> <i class="bi bi-download"></i></a>
									</div>
								</div>
								@endif
								@endforeach
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
@endsection