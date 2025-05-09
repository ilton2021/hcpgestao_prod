@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">PERMISSÃO:</h5>
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
		<div class="col-md-12">
			<p align="right"><a class="btn btn-dark btn-sm" style="color: #FFFFFF;" href="{{route('permissaoUsuarioNovo', $unidade->id)}}"> NOVA <i class="fas fa-check"></i> </a></p>
			<table class="table table-sm " id="my_table">
				<thead class="bg-success">
					<tr>
						<th scope="col">Usuário</th>
						<th scope="col">Alterar</th>
						<th scope="col">Excluir</th>
					</tr>
				</thead>
				<tbody>
					@foreach($userPermissao as $permissao)
					<tr>
						<input hidden type="text" id="idOrg" name="idOrg" value="<?php echo $permissao->id; ?>">
						<td style="font-size: 15px;">{{$permissao->Nome}}</td>
						<td><a class="btn btn-warning" href="{{route('permissaoAlterar', array($unidade->id, $permissao->user_id))}}"><i class="fas fa-edit"></i></a></td>
						<td> <a class="btn btn-danger btn-sm" href="{{route('permissaoExcluir', array($unidade->id, $permissao->user_id))}}" ><i class="fas fa-times-circle"></i> </td>
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