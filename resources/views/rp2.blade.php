@extends('layouts.app2')
@section('content')
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('js/utils.js') }}" rel="stylesheet">
	<link href="{{ asset('js/bootstrap.js') }}" rel="stylesheet">
	<link href="{{ asset('css/rp_cards.css') }}" rel="stylesheet">
</head>
<div class="container text-center" style="color: #28a745"></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 15px;"><b>Proposta de Contratação: {{ $unidades[0]->name }}</b></h5>
		</div>
	</div>
	<div class="row" style="margin-top: 10px; justify-content: center; display: block; margin:0 auto;">
		<center>
		  <section class="cards">				
			<div class="card">
				<div class="image"> 
					<img title="{{ $unidades[0]->sigla }}" src="{{asset('img')}}/{{$unidades[0]->path_img}}" alt="{{$unidades[0]->sigla}}">
				</div>
			</div>
		  </section> 
		</center>
	</div>
	<div class="row" style="margin-top: 25px;justify-content: center;">
		<table class="table table-sm table-striped" border="0">
			<thead>
				<td><center><b>Contratação de Serviços</b></center></td>
				<td><center><b>Período</b></center></td>
				<td></td>
			</thead> <?php $hoje = date('Y-m-d', strtotime('now')); ?> 
			@foreach($contratacao_servicos as $CS)
			@if(($CS->prazoFinal >= $hoje && $CS->prazoProrroga == NULL) || ($CS->prazoProrroga >= $hoje && $CS->prazoFinal <= $hoje) || ($CS->id == 6 || $CS->id == 24 || $CS->id == 8 || $CS->id == 309))
			<tr>
				<td>
					<p><center>- {!!$CS->titulo!!}</center></p>
				</td>
				<td>
					@if($CS->tipoPrazo == 1 && $CS->prazoProrroga == "")
					 <center>A partir do dia: <br><?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?> até o dia: <?php echo date('d/m/Y', strtotime($CS->prazoFinal)); ?></center>
					@elseif($CS->prazoProrroga != "")
					 <center>Prorrogado até o dia: <br><?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?></center>
					@elseif($CS->tipoPrazo == 0)
					 <center>A partir do dia: <br><?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?>, <br> faça o seu credenciamento</center>
					@endif
				</td>
				<td>
					<center>
						<a href="{{ route('rp3', array($CS->idUnidade, $CS->id)) }}" style="width= 100px; margin-top: 10px;" class="btn btn-sm btn-info">Visualizar</a>
					</center>
				</td>
			</tr>
			@endif
			@endforeach
			<tr>
				<td><center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center></td>
				<td colspan="2"><center><a href="{{route('rp')}}" style=" width: 100px; margin-top: 10px;" class="btn btn-sm btn-warning"><b>Voltar</b></a></center></td>
			</tr>
		</table>
	</div>
	<br><br>
</div>
</div>
@endsection