@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">REPASSES RECEBIDOS</h3>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 9) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)
			     <p align="right"><a href="{{route('cadastroRP', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <b>Alterar</b> <i class="fas fa-edit"></i> </a></p>
			   @endif
			  @endif
			 @endforeach
			@endif
		</div>
	</div> <br>

	<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
			@foreach ($anoRepasses as $ano)
			  <div class="col-2 d-inline-flex flex-wrap">
				<div class="p-2">
					<a class="btn btn-success btn-sm" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">
						<img src="{{asset('img/bank.png')}}" alt="" width="30" style="margin-right: 10px;"><strong>{{$ano}}</strong> 
					</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</div>
			  </div>
			@endforeach

	<?php $a = ''; ?>
	@foreach ($anoRepasses as $ano)
	<?php $a = $ano; ?>
	<div class="collapse border-0" id="{{$ano}}">
		<div class="card card-body border-0" style="background-color: #fafafa !important">
			<div class="row" style="margin-top: -25px;">
				<div class="col-md-12 col-sm-12 text-center">
					<div class="d-flex justify-content-end" style="margin-bottom: 10px;">
						<span class="badge badge-success"><a href="{{route('repassesExport', ['id'=> $unidade->id, 'year' => $ano])}}"><span class="badge badge-success"><b>Download EXCEL</b></span></a>
					</div>
					<table class="table table-hover table-sm table-success" style="font-size: 15px;">
						<thead class="bg-success">
							<tr>
								<th scope="col">Mês</th>
								<th scope="col">Ano</th>
								<th scope="col">Contratado</th>
								<th scope="col">Recebido</th>
								<th scope="col">Desconto</th>
								<th scope="col">Saldo a receber</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$mesAtual = "";
							for ($i = 1; $i <= 12; $i++) { ?>
								@foreach ($repasses as $repasse)
								@if($repasse->ano === $ano && $unidade->id == $repasse->unidade_id)
								<?php if ($i == 1) {
									$mesAtual = "janeiro";
								} elseif ($i == 2) {
									$mesAtual = "fevereiro";
								} elseif ($i == 3) {
									$mesAtual = "marco";
								} elseif ($i == 4) {
									$mesAtual = "abril";
								} elseif ($i == 5) {
									$mesAtual = "maio";
								} elseif ($i == 6) {
									$mesAtual = "junho";
								} elseif ($i == 7) {
									$mesAtual = "julho";
								} elseif ($i == 8) {
									$mesAtual = "agosto";
								} elseif ($i == 9) {
									$mesAtual = "setembro";
								} elseif ($i == 10) {
									$mesAtual = "outubro";
								} elseif ($i == 11) {
									$mesAtual = "novembro";
								} else {
									$mesAtual = "dezembro";
								} ?>
								@if($repasse->mes == $mesAtual)
								<tr>
									<td>{{$repasse->mes}}</td>
									<td>{{$ano}}</td>
									<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->contratado, 2,',','.'): '' }}</td>
									<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->recebido, 2,',','.'): '' }}</td>
									<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->desconto, 2,',','.'): '' }}</td>
									<td>{{ $ano === $repasse->ano ? "R$ ".number_format($repasse->contratado-$repasse->recebido, 2,',','.'): '' }}</td>
								</tr>
								@endif
								@endif
								@endforeach
							<?php } ?>
							<tr class="table-success">
								<td colspan="2"><strong>Total</strong></td>
								<td><strong>{{"R$ ".number_format($repasses->where('ano', $ano)->pluck('contratado')->sum(), 2,',','.') }}</strong></td>
								<td><strong>{{"R$ ".number_format($repasses->where('ano', $ano)->pluck('recebido')->sum(), 2,',','.') }}</strong></td>
								<td><strong>{{"R$ ".number_format($repasses->where('ano', $ano)->pluck('desconto')->sum(), 2,',','.') }}</strong></td>
								<td><strong>{{"R$ ".number_format(($repasses->where('ano', $ano)->pluck('contratado')->sum()-$repasses->where('ano', $ano)->pluck('recebido')->sum()), 2,',','.') }}</strong></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endforeach
</div>
</div>
@endsection