@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">OUVIDORIA</h3>
		</div>
	</div>
	<div class="row" style="">
		<div class="col-md-6 text-center">
			<a href="{{route('transparenciaOuvidoria', array($unidade->id,1))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
		</div>
		<div class="col-md-6 text-center">
			<a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoOV', $unidade->id)}}"> <b>Novo</b> <i class="fas fa-check"></i> </a>
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
		<div class="card m-2 rounded col-md-12 mr-2">
			@foreach($ouvidorias as $ouvidoria)
				<table class="table table-sm" border="0">
					<tr>
						<td> <strong>Responsável</strong> </td>
						<td> <strong>E-mail</strong> </td>
						<td> <strong>Telefone</strong> </td>
						<td> <strong><center>Alterar</center></strong> </td>
						@if($ouvidoria->status_ouvidoria == 1)
						<td> <strong><center>Inativar</center></strong> </td>
						@else
						<td> <strong><center>Ativar</center></strong> </td>
						@endif
					</tr>
					<tr>
						<td> {{ $ouvidoria->responsavel }} </td>
						<td> {{ $ouvidoria->email }} </td>
						<td> {{ $ouvidoria->telefone }} </td>
						<td> <center><a class="btn btn-info btn-sm" href="{{route('alterarOV', array($unidade->id, $ouvidoria->id))}}"><i class="fas fa-edit"></i></a> </center></td>
						@if($ouvidoria->status_ouvidoria == 0)
						<td> <center><a class="btn btn-success btn-sm" href="{{route('telaInativarOV', array($unidade->id, $ouvidoria->id))}}"><i class="fas fa-times-circle"></i></a> </center></td>
						@else
						<td> <center><a class="btn btn-warning btn-sm" href="{{route('telaInativarOV', array($unidade->id, $ouvidoria->id))}}"><i class="fas fa-times-circle"></i></a> </center></td>
						@endif
					</tr>
				</table>
			@endforeach
		</div>
	</div>
</div>
@endsection