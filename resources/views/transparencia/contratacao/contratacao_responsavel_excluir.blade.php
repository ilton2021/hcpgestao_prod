@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">DESVINCULAR GESTOR DO CONTRATO:</h3>
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
				  <div class="card-header" id="headingOne">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						<strong>Gestor do Contrato</strong>
					  </a>
					</h2>
				  </div>
				  <form method="POST" action="{{ route('destroyGestorContrato', array($unidade->id, $gestores[0]->id, $contrato[0]->id)) }}">
				  <input type="hidden" name="_token" value="{{ csrf_token() }}">
				  <table class="table table-sm">
				 		  <thead class="bg-success">
							 <tr>
								<th scope="col">Nome</th>
							 </tr>
						  </thead>
						  <tbody>
						   @if(!empty($gestores))
							 @foreach($gestores as $gContrato)
							  <tr> 
							    <td>{{$gContrato->nome}}</td>
							  </tr>
							 @endforeach
						   @endif	 
						  </tbody>
				  </table>
				  
				  <div class="card-header" id="headingTwo">
					<h2 class="mb-0">
					  <a class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
						<strong>Contrato</strong>
					  </a>
					</h2>
				  </div>
				  <table class="table table-sm">
				 	<thead class="bg-success">
					  <tr>
					    <th scope="col">ID</th>
						<th scope="col">Nome</th>
					  </tr>
					</thead>
					<tbody>
					 @foreach($contrato as $cont)
					  <tr>
					    <td>{{$cont->id}}</td>
						<?php $id = $cont->id; ?>
					    <td>{{$cont->objeto}}</td>
					  </tr>
					 @endforeach
					</tbody>
					<tr>
						<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="desvincularGestorContrato" /> </td>
						<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="destroyDesvincularGestorContrato" /> </td>
						<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
					</tr>
					<tr>
					  <td align="center" colspan="2"> 
					 	<div class="ml-2" style="color:black">
						  <p>
							<h6>Deseja realmente Desvincular este Gestor do Contrato?? </h6>
						  </p>
						</div>
						<a href="{{route('contratacaoCadastro', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
					  	<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Desvincular" id="Excluir" name="Excluir" />
					  </td>
					</tr>
				  </table>
				</form>
			</div>
		</div>							
	</div>
</div>
@endsection