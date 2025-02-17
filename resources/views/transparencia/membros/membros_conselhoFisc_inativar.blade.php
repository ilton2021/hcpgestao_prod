@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
		  @if($conselhoFisc->status_conselho_fiscs == 0)
			<h5 style="font-size: 18px;">ATIVAR MEMBROS DIRIGENTES:</h5>
		  @else
		    <h5 style="font-size: 18px;">INATIVAR MEMBROS DIRIGENTES:</h5>
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
						Conselho Fiscal: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{\Request::route('inativarCF'), $unidade->id}}" method="post" id="formid">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-3" style="color:black">
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<labe><strong>ID:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="type" id="id" name="id" value="<?php echo $conselhoFisc->id; ?>" disabled />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<labe><strong>Nome:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="text" id="name" name="name" value="<?php echo $conselhoFisc->name; ?>" disabled />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<labe><strong>Level:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" type="text" id="level" name="level" value="<?php echo $conselhoFisc->level; ?>" disabled />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-3 mr-4">
								<labe><strong>Tipo Membro:</strong></label>
							</div>
							<div class="col-md-8 mr-2">
								<input class="form-control form-control-sm" readonly type="text" id="tipo_membro" name="tipo_membro" value="Conselho Fiscal" />
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
							  <center>
							 	<h6> Deseja realmente Inativar este Membro Dirigente?? </h6>
								<a href="{{route('listarCF', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
								@if($conselhoFisc->status_conselho_fiscs == 0)
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
								<input hidden type="text" class="form-control" id="tela" name="tela" value="membrosConselhoFisc" />
								@if($conselhoFisc->status_conselho_fiscs == 0)
								<input hidden type="text" class="form-control" id="acao" name="acao" value="AtivarMembrosConselhoFisc" />
								@else
								<input hidden type="text" class="form-control" id="acao" name="acao" value="InativarMembrosConselhoFisc" />
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