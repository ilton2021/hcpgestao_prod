@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">MEMBROS DIRIGENTES</h5>
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
		<div class="col-md-12 col-sm-12">


			<div class="accordion" id="accordionExample">
				<div class="card">
					<div class="card-header d-flex flex-wrap justify-content-center justify-content-md-between" id="headingOne">
						<h5 class="mb-0">
							<a class="btn btn-link text-dark no-underline" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								SUPERINTENDENTES <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<a href="{{route('transparenciaMembros', ['id' => $unidade->id, 'escolha' => 'Superintendentes'])}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>	
							<li class="list-inline-item"><a id="Novo" name="Novo" type="button" class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('novoSUP', $unidade->id)}}"> <b>Novo</b> <i class="fas fa-check"></i> </a></li>	
						</h5>
					</div>
						    
						<div class="card-body">
							<div class="container text-center"><h5 style="font-size: 15px;"><strong>Estrutura Organizacional do Hospital de Câncer de Pernambuco - Superintendentes</strong></h5></div>
							<div class="row" >
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-12 col-sm-12" style="overflow:auto;">
									<table class="table table-sm">
										<thead >
											<tr class="text-center">
												<th class="border-bottom" scope="col">Nome</th>
												<th class="border-bottom" scope="col">Cargo</th>
												<th class="border-bottom" scope="col">Alterar</th>
												<th class="border-bottom" scope="col">Inativar</th>
											</tr>
										</thead>
										@foreach($superintendentes as $superintendente)
										<tbody class="">
											<tr>
												<td style="font-size: 12px;" width="30%">{{$superintendente->name}}</td>
												<td style="font-size: 12px;">{{$superintendente->cargo}}</td>
												<td> <center> <a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('alterarSUP', array($unidade->id, $superintendente->id))}}"><i class="fas fa-edit"></i></a> </center> </td>
												@if($superintendente->status_superintendentes == 0)
												<td> <center> <a title="Ativar" class="btn btn-success btn-sm" style="color: #00000;" href="{{route('telaInativarSUP', array($unidade->id, $superintendente->id))}}"><i class="fas fa-times-circle"></i></a> </center> </td>
												@else
												<td> <center> <a title="Inativar" class="btn btn-warning btn-sm" style="color: #00000;" href="{{route('telaInativarSUP', array($unidade->id, $superintendente->id))}}"><i class="fas fa-times-circle"></i></a> </center> </td>
												@endif
											</tr>
										</tbody>
										@endforeach	
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection