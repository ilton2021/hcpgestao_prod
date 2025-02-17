@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">GESTORES</h5>
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
								GESTORES <i class="far fa-list-alt"></i>
							</a>
						</h5>
						<h5 class="mb-0">
							<li class="list-inline-item"><a href="{{ route('novoGE', $unidade->id) }}" id="Novo" name="Novo" type="button" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo <i class="fas fa-check"></i> </a></li>	
							<a href="{{ route('cadastroContratos', $unidade->id) }}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</h5>
					</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-2 col-sm-0"></div>
								<div class="col-md-12 col-sm-12"  style="overflow:auto;">
									<table class="table table-sm">
										<thead >
											<tr class="text-center">
												<th class="border-bottom" scope="col">Nome</th>
												<th class="border-bottom" scope="col">E-mail</th>
												<th class="border-bottom" scope="col">Setor</th>
												<th class="border-bottom" scope="col">Alterar</th>
												<th class="border-bottom" scope="col">Inativar</th>
											</tr>
										</thead>
										<tbody>
											@foreach($gestores as $gestor)
												@csrf
												<tr>
													<td style="font-size: 12px;"><center>{{$gestor->nome}}</center></td>
													<td style="font-size: 12px;"><center>{{$gestor->email}}</center></td>
													<td style="font-size: 12px;"><center>{{$gestor->setor}}</center></td>
													<td> <center> <a class="btn btn-info btn-sm" href="{{route('alterarGE', array($unidade->id, $gestor->id))}}" ><i class="fas fa-edit"></i></a> </center> </td>
													@if($gestor->status_gestores == 0)
													  <td> <center> <a title="Ativar" class="btn btn-success btn-sm" href="{{route('telaInativarGE', array($unidade->id, $gestor->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
													@else
													  <td> <center> <a title="Inativar" class="btn btn-warning btn-sm" href="{{route('telaInativarGE', array($unidade->id, $gestor->id))}}" ><i class="fas fa-times-circle"></i></a> </center> </td>
													@endif
												</tr>
											</form>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class="col-md-2 col-sm-0"></div>
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