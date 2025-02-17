@extends('layouts.app2')
@section('title','Termo de Referência')
@section('content')
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/rp_cards.css') }}" rel="stylesheet">
</head>
<body>
<div class="container text-center" style="color: #28a745"></div>
  <div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 15px;"><b>Proposta de Contratação: {{ $unidades[0]->name }}</b></h5>
		</div>
	</div>
	<div class="row">
	<section class="cards">			
		<div class="card_rp3"> 
			<div class="row">
			  <div class="col">
				<div class="image3"> 
				  <img src="{{asset('img')}}/{{$unidades[0]->path_img}}" alt="{{$unidades[0]->sigla}}">
				</div>
			  </div>
			</div><br>
			  <div class="row">
				<div class="col">
				@foreach($contratacao_servicos as $CS)
					<p align="justify">{!!$CS->texto!!}</p> <hr>
					@foreach($especialidade_contratacao as $ec)
					 @foreach($especialidades as $es)
					  @if($es->id == $ec->especialidades_id)
					 	<p align="justify"><ul><li>{!!$es->nome!!}</li></ul></p><hr>
					  @endif 	  
					 @endforeach
					@endforeach
					@if($CS->tipoPrazo == 1 && $CS->prazoProrroga == "")
					  <center>As Propostas devem ser enviadas a partir do dia: <b><?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?></b> até o dia: <b><?php echo date('d/m/Y', strtotime($CS->prazoFinal)); ?></b>.</center>
					@elseif($CS->prazoProrroga != "")
					  <center>O envio das propostas foi prorrogado até o dia <b><?php echo date('d/m/Y', strtotime($CS->prazoProrroga)); ?></b>.</center>
					@elseif($CS->tipoPrazo == 0)
					  <center>As propostas devem ser enviadas a partir do dia: <b><?php echo date('d/m/Y', strtotime($CS->prazoInicial)); ?></b>, <br> faça o seu credenciamento. </center>
					@endif
					<hr>
					<center><a href="{{asset('storage/')}}/{{$CS->arquivo}}" style="width: 100px; margin-top: 10px;" class="btn btn-sm btn-info" target="_blank"><b>Download</b></a></center>
					<hr>
					@foreach($contratacao_erratas as $ce)
						<tr>
							<td>
								<center>Acesse a {{ $ce->posicao }}ª Errata do processo de Contratação aqui:
									<br>
									<a href="{{asset('storage/')}}/{{$ce->caminho}}" width="100px" class="btn btn-sm btn-info" target="_blank"><b>Download</b></a>
								</center>
							</td>
						</tr>
					@endforeach
				@endforeach 
				<br><center><b>Envie sua proposta para: contratacaodeservicos@hcpgestao.org.br</b></center>
			   </div>
			  </div>
			</div>
		</section>
	</div>
	<br><center><a href="{{route('rp2', $unidades[0]->id)}}" style=" width: 100px; margin-top: 10px;" class="btn btn-sm btn-warning"><b>Voltar</b></a></center>
  </div>
</div>
</section>
</body>
@endsection