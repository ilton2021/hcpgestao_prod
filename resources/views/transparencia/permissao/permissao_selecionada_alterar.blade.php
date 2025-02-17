@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	
	@if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
	<div class="row" style="margin-top: 30px;">
		<div class="col-md-12 text-center">
			<div class="card">
				<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
					ALTERAR PERMISSÃO DO USUÁRIO: <i class="fas fa-check-circle"></i>
				</a>
			</div>
			<form action="{{ route('updatePermissao', array($unidade->id, $permissoes[0]->user_id, $permissoes[0]->id)) }}" method="post" style="border: 1px solid gray; border-top: none; border-radius: 3px;">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<br>
				<table border="0" class="table-sm" style="line-height: 1.5;" >
					<label for="">Permissão: 
						<select name="permissao_id" id="permissao_id">
							@foreach($permissoesAll as $perm)
							<option value="<?php echo $perm->id; ?>">{{ $perm->tela }}</option>
							@endforeach
						</select>
					</label>
					<br>
					<br>
					<label for="">Unidade: 
						<select name="unidade_id" id="unidade_id">
							@foreach($unidades as $unidade)
							<option value="<?php echo $unidade->id; ?>">{{ $unidade->name }}</option>
							@endforeach
						</select>
					</label>
					<br>
					<br>
					<div>
						<a href="{{route('permissaoAlterar', array($unidade->id, $permissoes[0]->user_id))}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning" style="margin-top: 10px; margin-right: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-reply"></i> </a>
						<input style="color: #FFFFFF; margin-top: 9px;" type="submit" class="btn btn-success" value="Alterar" name="Salvar" id="Salvar">
					</div>
				</table>
				<br>
			</form>
		</div>
	</div> 
</div>
</div>
</div>
@endsection