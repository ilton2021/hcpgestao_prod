@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		   @if($contabilReports[0]->status_contabel == 0)
			 <h3 style="font-size: 18px;">ATIVAR DEMONSTRAÇÕES CONTÁBEIS E PARECERES:</h3>
		   @else
		     <h3 style="font-size: 18px;">INATIVAR DEMONSTRAÇÕES CONTÁBEIS E PARECERES:</h3> 
		   @endif
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
						Demonstrações Contabéis e Pareceres: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{\Request::route('inativarDC'), $unidade->id}}" method="post" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>ID:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="id" name="id" value="<?php echo $contabilReports[0]->id; ?>" />
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Título:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="title" name="title" value="<?php echo $contabilReports[0]->title; ?>" />
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Ano:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input readonly class="form-control form-control-sm" type="number" id="ano" name="ano" value="<?php echo $contabilReports[0]->ano; ?>" />
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<label><strong>Arquivo:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input readonly class="form-control form-control-sm" type="text" name="file_path" id="file_path" value="<?php echo $contabilReports[0]->file_path; ?>" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
							<center>
								<h6> Deseja realmente Inativar esta Demonstração Contábel e Parecer?? </h6>
								<a href="{{route('cadastroDC', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
								@if($contabilReports[0]->status_contabel == 0)
								  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Ativar" id="Ativar" name="Ativar" />
								@else
								  <input type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;" value="Inativar" id="Inativar" name="Inativar" />
								@endif
							</center>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
								<input hidden type="text" class="form-control" id="tela" name="tela" value="demonstrativoContabel" /> 
								@if($contabilReports[0]->status_contabel == 0)
								<input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarDemonstrativoContabel" /> 
								@else
								<input hidden type="text" class="form-control" id="acao" name="acao" value="InativarDemonstrativoContabel" /> 
								@endif
								<input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> 
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection