@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">CADASTRAR PERMISSÃO USUÁRIO:</h3>
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
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-2 col-sm-0"></div>
		<div class="col-md-8 col-sm-12 text-center">
		 <div class="accordion" id="accordionExample">
                <div class="card">
                    <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Permissão: <i class="fas fa-check-circle"></i>
                    </a>
			    </div>	
					 <form action="{{\Request::route('storePermissaoUsuario'), $unidade->id}}" method="post">
					 <input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table border="0" class="table-sm" style="line-height: 1.5;" >
						 <tr>
						   <td> Usuário </td>
						   <td>
						    <select id="user_id" name="user_id" class="form-control">
							  @foreach($users as $user)
							    <option id="user_id" name="user_id" value="<?php echo $user->id; ?>"> {{ $user->name }}</option>
							  @endforeach
							</select>
						   </td>
						 </tr>
						 <tr>
							<td> Tela/Ação: </td>
							<td>
							  <select id="permissao_id" name="permissao_id" class="form-control">
									<option style="width: 300px" id="permissao_id" name="permissao_id" value="0">TODAS</option>
								@foreach($permissoes as $permissao)
								   <option style="width: 300px" id="permissao_id" name="permissao_id" value="<?php echo $permissao->id; ?>"> {{ $permissao->tela .' | '. $permissao->acao }} </option>
								@endforeach
							  </select>
							</td>
						 </tr>
						 <tr>
						  <td> Unidades: </td>
						  <td>
						    <select id="unidade" name="unidade" class="form-control">
							    <option style="width: 300px" id="unidade" name="unidade" value="0"> TODAS </option>
								<option style="width: 300px" id="unidade" name="unidade" value="1"> HCP GESTAO </option>
								<option style="width: 300px" id="unidade" name="unidade" value="2"> HMR </option>
								<option style="width: 300px" id="unidade" name="unidade" value="3"> UPAE BELO JARDIM </option>
								<option style="width: 300px" id="unidade" name="unidade" value="4"> UPAE ARCOVERDE </option>
								<option style="width: 300px" id="unidade" name="unidade" value="5"> UPAE ARRUDA </option>
								<option style="width: 300px" id="unidade" name="unidade" value="6"> UPAE CARUARU </option>
								<option style="width: 300px" id="unidade" name="unidade" value="7"> HSS </option>
								<option style="width: 300px" id="unidade" name="unidade" value="8"> HPR </option>
								<option style="width: 300px" id="unidade" name="unidade" value="9"> UPA IGARASSU </option>
								<option style="width: 300px" id="unidade" name="unidade" value="10"> UPA PALMARES </option>
							</select>
						 </tr>
						</table>
						<table align="right">
						  <tr>
						   <td> <br /> <a class="btn btn-dark btn-sm" style="margin-top: 10px; color: #FFFFFF;" href="{{route('permissaoNovo', $unidade->id)}}" > Nova Permissão <i class="fas fa-check"></i></a> </td>
						  </tr>
						</table>
						<table>
						 <tr>
						   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
						 </tr>
						</table>
						<table>
						 <tr>
						  <td> <br /> <a href="{{route('cadastroPermissao', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a> </td>
						  <td> <br /> <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
						  
						 </tr>
						</table>
						</form>
		</div>
		<div class="col-md-2 col-sm-0"></div>
		</div>
    </div>
</div>
@endsection