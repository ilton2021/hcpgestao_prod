@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">EXCLUIR OUVIDORIA:</h3>
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
						<div class="card-body"  style="font-size: 14px;">
						<form action="{{\Request::route('destroyOV'), $unidade->id}}" method="post">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<table>
								<tr>
								 <td> <strong> Unidade: </strong> </td>
								 <td>
								    <select class="form-control" id="unidade_id" name="unidade_id" readonly="true">
								 	 @foreach($unidades as $und)
									  @if($und->id == $ouvidoria->unidade_id)
									   <option id="unidade_id" name="unidade_id" value="<?php echo $und->id; ?>"> {{ $und->sigla }} </option>
									  @endif
									 @endforeach
									</select>
								 </td>
								</tr>
							    <tr>
								 <td> <strong>Responsável:</strong> </td>
								 <td> <input disabled style="" class="form-control" type="text" id="responsavel" name="responsavel" value="<?php echo $ouvidoria->responsavel; ?>" /> </td> 
								</tr> 
								<tr>
								 <td> <strong> E-mail: </strong> </td>
								 <td> <input disabled style="width: 400px;" class="form-control" type="text" id="email" name="email"  value="<?php echo $ouvidoria->email; ?>" /> </td>
								</tr>
								<tr>
								 <td> <strong> Telefone: </strong> </td>
								 <td> <input disabled style="width: 400px" class="form-control" type="text" id="telefone" name="telefone"  value="<?php echo $ouvidoria->telefone; ?>" /> </td> 
								</tr>
								<tr>
								 <td> <strong> Atendimento presencial: </strong> </td>
    							 <td> <input disabled style="width: 400px" class="form-control" type="text" id="atendpresen" name="atendpresen"  value="<?php echo $ouvidoria->atendpresen; ?>" /> </td> 
    							</tr>
    							<tr>
    							    <td> <strong> Horário de funcionamento: </strong> </td>
    								 <td> <input disabled style="width: 400px" class="form-control" type="text" id="hrfunciona" name="hrfunciona"  value="<?php echo $ouvidoria->hrfunciona; ?>" /> </td> 
    							</tr>
    							</table>
							<table>
							  <tr>     
							    <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
								<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="Ouvidoria" /> </td>
								<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="ExcluirOuvidoria" /> </td>
								<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							  </tr>
							</table>
							
							<table>
								<tr>
								  <td align="left"> <br />
									<p><h6 align="left"> Deseja realmente Excluir esta Ouvidoria?? </h6></p>
									<a href="{{route('cadastroOV', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
									<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
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