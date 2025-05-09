@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR OUVIDORIA:</h3>
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
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
			<div id="accordion">
				<div class="card ">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Ouvidoria: <i class="fas fa-check-circle"></i>
					</a>
					<div class="card-body" style="font-size: 14px;">
						<form action="{{\Request::route('updateOV'), $unidade->id}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
								<tr>
									<td> <strong> Unidade: </strong> </td>
									<td> <select class="form-control" id="unidade_id" name="unidade_id" readonly="true">
											@if($ouvidoria->unidade_id == 1)
											<option id="unidade_id" name="unidade_id" value="1"> HCP GESTÃO </option>
											@elseif($ouvidoria->unidade_id == 2)
											<option id="unidade_id" name="unidade_id" value="2"> HOSPITAL DA MULHER DO RECIFE </option>
											@elseif($ouvidoria->unidade_id == 3)
											<option id="unidade_id" name="unidade_id" value="3"> UPAE BELO JARDIM </option>
											@elseif($ouvidoria->unidade_id == 4)
											<option id="unidade_id" name="unidade_id" value="4"> UPAE ARCOVERDE </option>
											@elseif($ouvidoria->unidade_id == 5)
											<option id="unidade_id" name="unidade_id" value="5"> UPAE ARRUDA </option>
											@elseif($ouvidoria->unidade_id == 6)
											<option id="unidade_id" name="unidade_id" value="6"> UPAE CARUARU </option>
											@elseif($ouvidoria->unidade_id == 7)
											<option id="unidade_id" name="unidade_id" value="7"> HOSPITAL SÃO SEBASTIÃO </option>
											@elseif($ouvidoria->unidade_id == 8)
											<option id="unidade_id" name="unidade_id" value="8"> HOSPITAL PROVISÓRIO DO RECIFE 1 </option>
											@elseif($ouvidoria->unidade_id == 9)
											<option id="unidade_id" name="unidade_id" value="9"> UPA IGARASSU </option>
											@elseif($ouvidoria->unidade_id == 10)
											<option id="unidade_id" name="unidade_id" value="10"> UPAE PALMARES </option>
											@endif
										</select>
									</td>
								</tr>
								<tr>
									<td> <strong>Responsável:</strong> </td>
									<td> <input style="" class="form-control" type="text" id="responsavel" name="responsavel" value="<?php echo $ouvidoria->responsavel; ?>" /> </td>
								</tr>
								<tr>
									<td> <strong> E-mail: </strong> </td>
									<td> <input style="width: 400px;" class="form-control" type="text" id="email" name="email" required value="<?php echo $ouvidoria->email; ?>" /> </td>
								</tr>
								<tr>
									<td> <strong> Telefone: </strong> </td>
									<td> <input style="width: 400px" class="form-control" type="text" id="telefone" name="telefone" required value="<?php echo $ouvidoria->telefone; ?>" /> </td>
								</tr>
								<tr>
									<td> <strong> Atendimento presencial: </strong> </td>
									<td> <input style="width: 400px" class="form-control" type="text" id="atendpresen" name="atendpresen" value="<?php echo $ouvidoria->atendpresen; ?>" /> </td>
								</tr>
								<tr>
									<td> <strong> Horário de funcionamento: </strong> </td>
									<td> <input style="width: 400px" class="form-control" type="text" id="hrfunciona" name="hrfunciona" value="<?php echo $ouvidoria->hrfunciona; ?>" /> </td>
								</tr>
							</table>
							<table>
								<tr>
									<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
									<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Ouvidoria" /> </td>
									<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="AlterarOuvidoria" /> </td>
									<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
								</tr>
							</table>

							<table>
								<tr>
									<td align="left"> <br />
										<a href="{{route('cadastroOV', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
										<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Alterar" id="Alterar" name="Alterar" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 col-sm-0"></div>
	<br /> <br />
</div>
</div>
@endsection