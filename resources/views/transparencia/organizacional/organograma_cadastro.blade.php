@extends('navbar.default-navbar')
@section('content')

@if ($errors->any())
@foreach ($errors->all() as $error)
@if(strpos((strtolower($error)), "sucesso") == false)
<div class="alert alert-danger text-center" style="font-size:16px;">
	<ul class="list-unstyled">
		<li>{{ $error }}</li>
	</ul>
</div>
@else
<div class="alert alert-success text-center" style="font-size:16px;">
	<ul class="list-unstyled">
		<li>{{ $error }}</li>
	</ul>
</div>
@endif
@endforeach
@endif

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">ARQUIVO DO ORGANOGRAMA</h5>
		</div>
	</div>
	<div class="d-flex justify-content-between">
		<div class="p-2">
			<a href="{{route('transparenciaOrganizacional', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
		</div>
		<div class="p-2">
			<?php if (sizeof($arqOrgano) == 0) { ?>
				<a href="{{route('novoOG', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> <b>Novo</b> <i class="fas fa-check"></i> </a>
			<?php } else { ?>
				<a href="{{route('novoOG', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <b>Substituir</b> <i class="fas fa-check"></i> </a>
				@if($arqOrgano[0]->status_organograma == 0)
				<a title="Ativar" class="btn btn-success btn-sm" href="{{route('telaInativarOG', $unidade->id)}}"><i class="fas fa-times-circle"></i></a>
				@else
				<a title="Inativar" class="btn btn-warning btn-sm" href="{{route('telaInativarOG', $unidade->id)}}"><i class="fas fa-times-circle"></i></a>
				@endif
			<?php } ?>
		</div>
	</div>
	<?php if (sizeof($arqOrgano) > 0) { ?>
		<div class="embed-responsive embed-responsive-16by9">
			<iframe class="embed-responsive-item" src="{{asset('storage')}}/{{$arqOrgano[0]->file_path}}"></iframe>
		</div>
	<?php } ?>
</div>
@endsection