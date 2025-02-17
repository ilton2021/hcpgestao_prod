@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">VINCULAR GESTOR(ES) AO CONTRATO:</h3>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
				  <div class="card-header" id="headingThree">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
						<strong>Gestores</strong> 
					  </a>
					</h2>
				  </div>
				    <form method="POST" action="{{ route('procurarPrestador', $unidade->id) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				    <table class="table table-sm" border="0">
					  <tr>
						<td> <a href="{{route('cadastroContratos', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a> </td>
					    <td width="100px"> 
						  <select id="funcao" name="funcao" class="form-control" style="width: 200px;"> 
					         <option id="funcao" name="funcao" value="0">Nome</option> 
						     <option id="funcao" name="funcao" value="1">E-mail</option> 
						  </select>
						</td>
						<td> <input class="form-control" type="text" id="pesq" name="pesq" /> </td>
						<td width="100px"> <input type="submit" class="btn btn-info btn-sm" value="Pesquisar" id="Pesquisar" name="Pesquisar" /> </td>
					  </tr>
					</table>
					</form>
				    <table class="table table-sm">
				  	  <thead class="bg-success">
						<tr>
					  	  <th scope="col">Nome</th>
						  <th scope="col">Email</th>
						  <th scope="col">Selecionar</th>
						</tr>
					  </thead> 
					  <tbody>
					   @foreach($gestores as $gestor)
						<tr>
						  <td style="font-size: 18px;">{{$gestor->nome}}</td>
						  <td style="font-size: 18px;">{{$gestor->email}}</td>
						  <td> <a class="btn btn-success btn-sm" style="color: #FFFFFF;" href="{{route('validarGestorContrato', array($unidade->id, $gestor->id, 1))}}"> <i class="fas fa-check"></i></a> </td>
						</tr>
					   @endforeach
					  </tbody>
					</table>
				  </form>
				</div>
			</div>
		</div>							
	</div>
</div>
@endsection