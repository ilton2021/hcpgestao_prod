@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ALTERAR PERMISSÕES DO USUÁRIO <strong>{{$permissoes[0]->Nome}}</strong>:</h5>
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
		<a style="margin-bottom: 10px; margin-left: 14px; color: #FFFFFF" href="{{route('cadastroPermissao', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning" style="margin-top: 10px; margin-right: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-reply"></i> </a>
		<div class="col-md-12">
			<table class="table table-sm " id="my_table">
				<thead class="bg-success">
					<tr>
						<th scope="col">Permissão</th>
						<th scope="col">Unidade</th>
						<th scope="col">Alterar</th>
					</tr>
				</thead>
				<tbody>
					@foreach($permissoes as $permissao)
					<tr>
						<input hidden type="text" id="idOrg" name="idOrg" value="<?php echo $permissao->id; ?>">
						<td style="font-size: 15px;">{{$permissao->Permissao}}</td>
						<td style="font-size: 15px;">{{$permissao->Unidade}}</td>
						<td>
							<a class="btn btn-warning" href="{{ route('permissaoSelecionadaAlterar', array($unidade->id, $permissao->user_id, $permissao->id)) }}"><i class="fas fa-edit"></i></a>
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