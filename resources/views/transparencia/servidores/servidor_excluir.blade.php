@extends('navbar.default-navbar')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">EXCLUIR SERVIDORES CEDIDOS:</h5>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						SERVIDORES CEDIDOS: <i class="fas fa-check-circle"></i>
					</a>
				</div>
					<form action="{{\Request::route('destroySE'), $unidade->id}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						 <table>
						  <tr>
							<td> Nome: </td>
							<td> &nbsp; </td>
							<td> <input style="width: 450px;" class="form-control" type="text" id="nome" name="nome" value="<?php echo $servidores[0]->nome ?>" readonly="true" />  </td>
						  </tr>
						  <tr>
							<td> Cargo: </td> 
							<td> &nbsp; </td>
							<td> <input style="width: 450px;" class="form-control" type="text" id="cargo" name="cargo" value="<?php echo $servidores[0]->cargo ?>" readonly="true" /> </td>
						  </tr>
						  <tr>
							<td> Matrícula: </td> 
							<td> &nbsp; </td>
							<td> <input style="width: 450px;" class="form-control" type="text" id="matricula" name="matricula" value="<?php echo $servidores[0]->matricula ?>" readonly="true" /> </td>
						  </tr>
						  <tr>
							<td> E-mail: </td> 
							<td> &nbsp; </td>
							<td> <input style="width: 450px;" class="form-control" type="text" id="email" name="email" value="<?php echo $servidores[0]->email ?>" readonly="true" /> </td>
						  </tr>
						  <tr>
							<td> Telefone: </td> 
							<td> &nbsp; </td>
							<td> <input style="width: 450px;" class="form-control" type="text" id="fone" name="fone" value="<?php echo $servidores[0]->fone ?>" readonly="true" /> </td>
						  </tr>
						  <tr>
							<td> Data Início na Unidade: </td> 
							<td> &nbsp; </td>
							<td> <input style="width: 450px;" class="form-control" type="text" id="data_inicio" name="data_inicio" value="<?php echo $servidores[0]->data_inicio ?>" readonly="true" /> </td>
						  </tr>
						  <tr>
							<td> Observação: </td> 
							<td> &nbsp; </td>
							<td> <textarea class="form-control" cols="10" rows="5" type="text" id="observacao" name="observacao" value="<?php echo $servidores[0]->observacao ?>" readonly="true"></textarea></td>
						  </tr>
						  <input hidden style="width: 450px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
						</table>
						<table>
						  <tr>
						    <td> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="ServidoresCedidos" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="alterarServidoresCedidos" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						  </tr>
						</table>
						<table>
							<tr>
								<td> <br /> 
									<a href="{{route('transparenciaRecursosHumanos', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Salvar" name="Salvar" />
								</td>
							</tr>
						</table>
					</form>	
				</div>
			</div>
		</div>
@endsection