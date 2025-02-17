@extends('navbar.default-navbar')
@section('content')

<style>
	:root {
		--bg: #dcdde1;
		--color-icon: #535c68;
		--social-icon1: #e4405f;
		--social-icon2: #3b5999;
		--social-icon3: #e4405f;
		--social-icon4: #cd201f;
		--social-icon5: #0077B5;
	}

	* {
		margin: 0;
		padding: 0;
	}

	section {
		width: 100%;
		height: 100vh;
		display: flex;
		align-items: center;
		justify-content: center;
		background: var(--bg);
		z-index: -10;
	}

	.icon-list {
		width: 100%;
		max-width: 50rem;
		padding: 0 1.5rem;
		display: flex;
		justify-content: space-between;
	}

	.icon-item {
		list-style: none
	}

	.icon-link {
		display: inline-flex;
		font-size: 3rem;
		text-decoration: none;
		color: var(--color-icon);
		width: 3rem;
		height: 3rem;
		transition: .5s linear;
		position: relative;
		z-index: 1;
		margin: auto
	}

	.icon-link:hover {
		color: #fff;
	}

	.icon-link i {
		margin: auto;
	}

	.icon-link::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 3rem;
		height: 3rem;
		background: green;
		border-radius: 50%;
		z-index: -1;
		transform: scale(0);
		transition: 0.3s cubic-bezier(.95, .32, .37, 1.21);
	}

	.icon-link:hover::before {
		transform: scale(1);
	}

	.icon-item:nth-child(1) a:hover:before {
		background: var(--social-icon1);
	}

	.icon-item:nth-child(2) a:hover:before {
		background: var(--social-icon2);
	}

	.icon-item:nth-child(3) a:hover:before {
		background: var(--social-icon3);
	}

	.icon-item:nth-child(4) a:hover:before {
		background: var(--social-icon4);
	}

	.icon-item:nth-child(5) a:hover:before {
		background: var(--social-icon5);
	}
</style>

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">

	<div class="d-flex flex-column text-center mt-3">
		<div>
			<h3 style="font-size: 18px;">SERVIDORES CEDIDOS</h3>
		</div>
		<div class="d-flex justify-content-around">
			<div>
				<a href="{{route('transparenciaRecursosHumanos', array($unidade->id))}}" class="btn btn-warning btn-sm" style="color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a> &nbsp;&nbsp;
				<a href="{{route('novoSE', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> Novo Servidor <i class="fas fa-check"></i> </a> &nbsp;&nbsp;
				<a href="{{route('novoJS', array($unidade->id, 1))}}" class="btn btn-primary btn-sm" style="color: #FFFFFF;"> Nova Justificativa <i class="fas fa-check"></i> </a>
			</div>
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
	@if($unidade->id == 8)
			<table class="table table-sm " id="my_table">
				<thead class="bg-success">
					<tr>
						<th scope="col">Cargo</th>
						<th scope="col">Nome</th>
						<th scope="col">Matrícula</th>
						<th scope="col">Data Início</th>
						<th scope="col">Alterar</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>				
					@foreach($servidores as $servidor)
					<tr>
						<td style="font-size: 11px;">{{$servidor->cargo}}</td>
						<td style="font-size: 11px;">{{$servidor->nome}}</td>
						<td style="font-size: 11px;">{{$servidor->matricula}}</td>
						<td style="font-size: 11px;">{{date('d-m-Y',strtotime($servidor->data_inicio))}}</td>
						<td> <a class="btn btn-info btn-sm" href="{{route('servidoresAlterar', array($servidor->id, $unidade->id))}}" ><i class="fas fa-edit"></i></a> </td>
						<td> <a class="btn btn-danger btn-sm" href="{{route('servidoresExcluir', array($servidor->id, $unidade->id))}}" ><i class="fas fa-times-circle"></i> </td>
					</tr>
					@endforeach
				</tbody>
			</table>
	@endif

	@if($unidade->id != 8)
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		  <div class="col-md-10 col-sm-12 text-center">
			@foreach ($justificativa as $js)
			<div class="border border-success rounded rounded-3 m-3">
				<div class="card card-body border border-success rounded rounded-3 m-3" style="background-color: #fafafa">
					<h6> Justificativa </h6>
					  <div class="d-flex flex-column justify-content-center border-bottom border-success">
						<div class="d-md-inline-flex justify-content-between">
							<div class="p-2">
								
								<a class="btn btn-success" style="color: #FFFFFF; font-size:12px" href="{{asset('storage')}}/{{$js->caminho}}" target="_blank" >{{$js->nome}} <i class="bi bi-download"></i></a>
							</div>
							<div class="d-inline-flex">
								<div class="p-2 mt-2">
									@if($js->status == 0)
									<a title="Ativar" class="btn btn-success btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarJS', array($unidade->id, $js->id))}}"><i class="fas fa-times-circle"></i></a>
									@else
									<a title="Inativar" class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarJS', array($unidade->id, $js->id))}}"><i class="fas fa-times-circle"></i></a>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		<div class="col-md-1 col-sm-0"></div>
	</div>
	@endif
</div>
@endsection