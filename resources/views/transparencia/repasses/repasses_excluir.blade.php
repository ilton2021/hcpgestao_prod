@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR REPASSES RECEBIDOS:</h3>
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
						Repasses: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
			<form action="{{\Request::route('destroyRP'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-control mt-0" style="color:black">
					<div class="form-row mt-3">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-1 mr-2">
								<label><strong>ID:</strong></label>
							</div>
							<div class="col-md-4 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="id" name="id" value="<?php echo $repasses[0]->id; ?>" />	
							</div>
							<div class="col-md-2 mr-2">
								<label><strong>Mês:</strong></label>
							</div>
							<div class="col-md-4 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="<?php echo $repasses[0]->mes; ?>" />	
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-1 mr-2">
								<label><strong>Ano:</strong></label>
							</div>
							<div class="col-md-4 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="ano" name="ano" value="<?php echo $repasses[0]->ano; ?>" />	
							</div>
							<div class="col-md-2 mr-2">
								<label><strong>Desconto:</strong></label>
							</div>
							<div class="col-md-4 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="desconto" name="desconto" value="<?php echo $repasses[0]->desconto; ?>" onkeyup="formatarMoeda('desconto')"/>
							</div>
						</div>
					</div>
					<div class="form-row mt-1">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-4">
								<label><strong>Recebido:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="recebido" name="recebido" value="<?php echo $repasses[0]->recebido; ?>" onkeyup="formatarMoeda('recebido')"/>
							</div>
						</div>
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-4 mr-4">
								<label><strong>Contratado:</strong></label>
							</div>
							<div class="col-md-6 mr-2">
								<input readonly class="form-control form-control-sm" type="text" id="contratado" name="contratado" value="<?php echo $repasses[0]->contratado; ?>" onkeyup="formatarMoeda('contratado')"/>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
								<p align="left"><h6> Deseja realmente Excluir este Repasse Recebido?? </h6></p>
							</div>
						</div>
					</div> 
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
								<center>
									<a href="{{route('cadastroRP', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
								</center>
							</div>
						</div>
					</div>
					<div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
							<input hidden type="text" class="form-control" id="tela" name="tela" value="repasses" /> 
							<input hidden type="text" class="form-control" id="acao" name="acao" value="excluirRepasses" /> 
							<input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> 
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection