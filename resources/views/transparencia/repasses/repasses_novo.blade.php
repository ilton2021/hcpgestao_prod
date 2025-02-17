@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR REPASSES RECEBIDOS:</h3>
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
	<div class="row" style="margin-top: 25px; margin-left: auto; margin-right: auto; display: flex; justify-content: center">
		<div class="col-md-10 col-sm-4 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Repasses: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{ \Request::route('storeRP', $unidade->id) }}" method="post" id="formid">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-0" style="color:black;">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-2">
								<label><strong>Mês:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<select id="mes" name="mes" class="form-control form-control-sm" required>
									<option value="">Selecione...</option>
									<option value="janeiro">Janeiro</option>
									<option value="fevereiro">Fevereiro</option>
									<option value="marco">Março</option>
									<option value="abril">Abril</option>
									<option value="maio">Maio</option>
									<option value="junho">Junho</option>
									<option value="julho">Julho</option>
									<option value="agosto">Agosto</option>
									<option value="setembro">Setembro</option>
									<option value="outubro">Outubro</option>
									<option value="novembro">Novembro</option>
									<option value="dezembro">Dezembro</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-2">
								<label><strong>Ano:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<select id="ano" name="ano" class="form-control form-control-sm" required>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
									<option value="2021">2021</option>
									<option value="2022">2022</option>
									<option value="2023">2023</option>
									<option value="2024" selected>2024</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-2">
								<label><strong>Contratado:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<input class="form-control form-control-sm" type="number" step="any" id="contratado" name="contratado" value="{{ old('contratado') }}" required onkeyup="formatarMoeda('contratado')"/>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-2">
								<label><strong>Recebido:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<input class="form-control form-control-sm" type="number" step="any" id="recebido" name="recebido" value="{{ old('recebido') }}" required onkeyup="formatarMoeda('recebido')"/>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-2">
								<label><strong>Desconto:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<input class="form-control form-control-sm" type="number" step="any" id="desconto" name="desconto" value="{{ old('desconto') }}" required onkeyup="formatarMoeda('desconto')"/>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
								<center>
									<a href="{{route('cadastroRP', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a> &nbsp;&nbsp;&nbsp;&nbsp;
									<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
								</center>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							<input hidden type="text" class="form-control" id="tela" name="tela" value="repasses" /> 
							<input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRepasses" /> 
							<input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<script>
	function formatarMoeda(input) {
		var elemento = document.getElementById(input);
		var valor = elemento.value;
		valor = valor + '';
		valor = parseInt(valor.replace(/[\D]+/g, ''));
		valor = valor + '';
		valor = valor.replace(/([0-9]{2})$/g, ".$1");

		if (valor.length > 6) {
			valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, "$1.$2");
		}

		elemento.value = valor;
		if (valor == 'NaN') elemento.value = '';
	}
</script>
@endsection