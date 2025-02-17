@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">PRESTADOR:</h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
				  <div class="card-header" id="headingThree">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<strong>Prestador</strong>
					  </a>
					</h2>
				</div>
				<form method="POST" action="{{ route('procurarPrestadorCad', $unidade->id) }}">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<table class="table table-sm" border="0">
				    <tr>
						<td> <a href="{{route('cadastroContratos', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a> </td>
				 	    <td width="100px"> 
							<select id="funcao" name="funcao" class="form-control" style="width: 200px;"> 
						        <option id="funcao" name="funcao" value="0">Nome</option> 
							    <option id="funcao" name="funcao" value="1">CNPJ/CPF</option> 
							    <option id="funcao" name="funcao" value="2">Tipo de Contrato</option> 
								<option id="funcao" name="funcao" value="3">Tipo de Pessoa</option> 
							</select>
						</td>
						<td> <input class="form-control" type="text" id="pesq" name="pesq" /> </td>
						<td width="100px"> <input type="submit" class="btn btn-info btn-sm" value="Pesquisar" id="Pesquisar" name="Pesquisar" /> </td>
						<td width="100px">
						 <h5 class="mb-0">
						   <li class="list-inline-item"><a href="{{ route('prestadorCadastro', $unidade->id) }}" id="Novo" name="Novo" type="button" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></li>	
						 </h5> 
						</td>
					</tr>
				</table>
				</form>
				<table class="table table-sm">
					<thead class="bg-success">
						<tr>
							<th scope="col">Prestador</th>
							<th scope="col">CNPJ/CPF</th>
							<th scope="col" style="width: 250px">Tipo Contrato/Tipo Pessoa</th>
							<th scope="col">Alterar</th>
							<th scope="col">Inativar</th>
				   	    </tr>
				    </thead>
					<tbody>
				    @if(!empty($prestadores))
				 	  @foreach($prestadores as $prestador)
						<tr>
							<td style="font-size: 11px;">{{$prestador->prestador}}</td>
							<td style="font-size: 11px;">{{$prestador->cnpj_cpf}}</td>
							<td style="font-size: 11px;">{{$prestador->tipo_contrato}} / {{$prestador->tipo_pessoa}}</td>
							<td> <a href="{{route('prestadorAlterar', array($unidade->id, $prestador->id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <i class="fas fa-edit"></i> </td>
							@if($prestador->status_prestadors == 0)
							  <td> <center> <a title="Ativar" class="btn btn-success btn-sm" href="{{route('prestadorInativar', array($unidade->id, $prestador->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
							@else
							  <td> <center> <a title="Inativar" class="btn btn-warning btn-sm" href="{{route('prestadorInativar', array($unidade->id, $prestador->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
							@endif
						</tr>
					  @endforeach
					@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>							
  </div>
</div>
@endsection