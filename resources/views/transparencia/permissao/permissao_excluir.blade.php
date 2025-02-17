@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">EXCLUIR PERMISSÃO DO USUÁRIO:</h5>
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
	<p style="color: black;">USUARÍO: {{$permissoes[0]->Nome}}</p>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12">
			<div class="container text-center">
				<div class="row justify-content-center">
					<div class="col-4" style="margin-right: 155px;">
						<p align="left"><a class="btn btn-warning btn-sm" style="color: #FFFFFF" href="{{ route('cadastroPermissao', $unidad[0]->id) }}">VOLTAR<i class="fas fa-reply"></i></a></p>
					</div>
					<div class="col-4" style="margin-left: 155px;">
						<p align="right">
							<form action="{{route('deletePermissoesAll', array($unidade->id, $permissoes[0]->user_id))}}" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-danger btn-sm" id="Salvar" name="Salvar"> EXCLUIR TODAS AS PERMISSÕES  <i class="fas fa-times-circle"></i></button>
							</form>	
						</p>
					</div>
				</div>
			</div>
			<table class="table table-sm " id="my_table">
				<thead class="bg-success">
					<tr>
						<th scope="col">PERMISSÃO</th>
						<th scope="col">UNIDADE</th>
						<th scope="col">EXCLUIR</th>
					</tr>
				</thead>
				<tbody>
					@foreach($permissoes as $permissao)
					<tr>
						<td style="font-size: 15px;">{{ $permissao->Permissao }}</td>
						<td style="font-size: 15px;">{{ $permissao->Unidade }}</td>
						<td>
							<form action="{{route('deletePermissao', array($unidade->id, $permissao->id, $permissao->user_id))}}" method="post">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<button type="submit" class="btn btn-danger btn-sm" id="Salvar" name="Salvar"><i class="fas fa-times-circle"></i></button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div> 
</div>
</div>
</div>
@endsection