@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR DEMONSTRATIVOS FINANCEIROS:</h3>
		</div>
	</div>
	@if ($errors->any())
	<div class="alert alert-danger">
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
						Demonstrativos Financeiros: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{\Request::route('updateDF'), $unidade->id}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-1">
								<label><strong>Título:</strong></label>
							</div>
							<div class="col-md-4 mr-4">
								<select id="title" name="title" class="form-control form-control-sm">
									<?php
										$s1 = "";
										$s2 = "";
										$s3 = "";
										if (strpos($financialReports[0]->title, "Relátorio Mensal") !== false) {
											echo "aqui";
											$s1 = "selected";
											$s2 = "";
											$s3 = "";
										} elseif (strpos($financialReports[0]->title, "Prestação de contas") !== false) {
											$s1 = "";
											$s2 = "selected";
											$s3 = "";
										} else {
											$s1 = "";
											$s2 = "";
											$s3 = "selected";
										}
									?>
									<option <?php echo $s1 ?> value="1">Relátorio Mensal</option>
									<option <?php echo $s2 ?> value="2">Prestação de contas</option>
									<option <?php echo $s3 ?> value="3">Relátorio Anual</option>
								</select>
							</div>
							<div class="col-md-2 mr-1">
								<label><strong>Tipo doc:</strong></label>
							</div>
							<div class="col-md-3 mr-4">
								<select id="tipodoc" name="tipodoc" class="form-control form-control-sm">
									<option <?php echo $financialReports[0]->tipodoc == "1" ? "selected" : ""; ?> value="1">Padrão</option>
									<option <?php echo $financialReports[0]->tipodoc == "2" ? "selected" : ""; ?> value="2">Maternidade</option>
									<option <?php echo $financialReports[0]->tipodoc == "3" ? "selected" : ""; ?> value="3">COVID</option>
									<option <?php echo $financialReports[0]->tipodoc == "4" ? "selected" : ""; ?> value="4">Prefeitura</option>
									<option <?php echo $financialReports[0]->tipodoc == "5" ? "selected" : ""; ?> value="5">Emenda</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-0 mr-4">
								<label><strong>Periodo:</strong></label>
							</div>
							<div class="col-md-3 mr-4">
								<select id="periodo" name="periodo" class="form-control form-control-sm" onchange="periodo(val)">
									<option value="M">Mensal</option>
									<option value="A">Anual</option>
								</select>
							</div>
							<div class="col-md-1 mr-1">
								<label><strong>Mês:</strong></label>
							</div>
							<div class="col-md-3 mr-2">
								<select id="mes" name="mes" class="form-control form-control-sm">
									<option <?php echo $financialReports[0]->mes == "1" ? "selected" : ""; ?> value="1">Janeiro</option>
									<option <?php echo $financialReports[0]->mes == "2" ? "selected" : ""; ?> value="2">Fevereiro</option>
									<option <?php echo $financialReports[0]->mes == "3" ? "selected" : ""; ?> value="3">Março</option>
									<option <?php echo $financialReports[0]->mes == "4" ? "selected" : ""; ?> value="4">Abril</option>
									<option <?php echo $financialReports[0]->mes == "5" ? "selected" : ""; ?> value="5">Maio</option>
									<option <?php echo $financialReports[0]->mes == "6" ? "selected" : ""; ?> value="6">Junho</option>
									<option <?php echo $financialReports[0]->mes == "7" ? "selected" : ""; ?> value="7">Julho</option>
									<option <?php echo $financialReports[0]->mes == "8" ? "selected" : ""; ?> value="8">Agosto</option>
									<option <?php echo $financialReports[0]->mes == "9" ? "selected" : ""; ?> value="9">Setembro</option>
									<option <?php echo $financialReports[0]->mes == "10" ? "selected" : ""; ?> value="10">Outubro</option>
									<option <?php echo $financialReports[0]->mes == "11" ? "selected" : ""; ?> value="11">Novembro</option>
									<option <?php echo $financialReports[0]->mes == "12" ? "selected" : ""; ?> value="12">Dezembro</option>
								</select>
							</div>
							<div class="col-md-1 mr-1">
								<label><strong>Ano:</strong></label>
							</div>
							<div class="col-md-2 mr-1">
								<?php
									$dataini = date('Y', strtotime('now')) - 20;
									$datafim = date('Y', strtotime('now')) + 10;
								?>
								<select class="form-control form-control-sm" id="ano" name="ano">
									<?php for ($a = $dataini; $a <= $datafim; $a++) { ?>
										@if($a == $financialReports[0]->ano)
											<option id="ano" name="ano" value="<?php echo $a; ?>" selected>{{ $a }}</option>
										@else
											<option id="ano" name="ano" value="<?php echo $a; ?>">{{ $a }}</option>
										@endif
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							@if($financialReports[0]->tipoarq == 0 || $financialReports[0]->tipoarq == 1 || $financialReports[0]->tipoarq == 2)
								<div class="col-md-3 mr-1">
									<label class=""><strong>Arquivo atual:</strong></label> 
								</div>
								<div class="col-md-8 mr-2">
									<input class="form-control form-control-sm" type="text" id="file_path_orig" name="file_path_orig" value="<?php echo (explode("/", $financialReports[0]->file_path))[3]; ?>" disabled />
								</div>
							@elseif($financialReports[0]->tipoarq == 3)
								<div class="col-md-2 mr-1">
									<label class=""><strong>Arquivo atual:</strong></label>
								</div>
								<div class="col-md-3 mr-4">
									<input class="form-control form-control-sm" type="text" id="file_link_orig" name="file_link_orig" value="" placeholder="{{$financialReports[0]->file_link}}" disabled />
								</div>
							@endif 
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-2 mr-3">
								<select id="tipoarq" name="tipoarq" class="form-control form-control-sm">
									<option {{$financialReports[0]->tipoarq == 1 ? "selected" : ""}} value="1">PDF</option>
									<option {{$financialReports[0]->tipoarq == 2 ? "selected" : ""}} value="2">RAR</option>
									<option {{$financialReports[0]->tipoarq == 3 ? "selected" : ""}} value="3">LINK</option>
								</select>
							</div>
							<div class="col-md-9 mr-3" name="vinculado" id="vinculado">
								<input class="form-control form-control-sm" type="file" id="file_path" name="file_path" value="" />
							</div>
							<div class="col-md-9 mr-3" name="vinculado2" id="vinculado2">
								<input class="form-control form-control-sm" type="text" id="file_link" name="file_link" placeholder="Cole o link do arquivo.." />
							</div>
						</div>
					</div>
				</div>
				
				<table>
					<tr>
						<td> <input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoFinanceiro" /> </td>
						<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarDemonstrativoFinanceiro" /> </td>
						<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					</tr>
				</table>
				<div class="d-flex justify-content-between">
					<div>
						<a href="{{route('cadastroDF', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
					</div>
					<div>
						<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
					</div>
				</div>
			</form>
		</div>
	</div>
			</div>
		</div>
<script>
	$('#file_path').on('change', function() {
		if (this.files[0].size > 16777216) {
			$('#GFG_DOWN').text("Insira um arquivo com 16 Mega bytes ou menos !");
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#vinculado2').hide();
		$('#tipoarq').change(function() {
			if ($('#tipoarq').val() == 1) {
				$('#vinculado').show();
				$('#vinculado2').hide();
			}
		});
		$('#tipoarq').change(function() {
			if ($('#tipoarq').val() == 2) {
				$('#vinculado2').hide();
				$('#vinculado').show();
			}
		});
		$('#tipoarq').change(function() {
			if ($('#tipoarq').val() == 3) {
				$('#vinculado').hide();
				$('#vinculado2').show();
			}
		});
	});

	function _(el) {
		return document.getElementById(el);
	}
</script>
@endsection