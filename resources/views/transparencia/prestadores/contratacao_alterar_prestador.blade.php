@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">ALTERAR PRESTADOR:</h3>
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
					  <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Prestador <i class="fas fa-check-circle"></i>
					  </a>
				    <form action="{{ route('updatePrestador', array($unidade->id, $prestadores[0]->id))}}" method="post">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<table class="table table-sm">
							<tr>
							  <td> Prestador: </td>
							  <td>  
								<input style="width: 500px" class="form-control form-control-sm" type="text" id="prestador" name="prestador" value="<?php echo $prestadores[0]->prestador; ?>" required />
							  </td>
						    </tr>
							<tr>
							  <td> CNPJ/CPF: </td>
							  <td> <input style="width: 300px" class="form-control form-control-sm" type="text" id="cnpj_cpf" name="cnpj_cpf" value="<?php echo $prestadores[0]->cnpj_cpf; ?>" required /> </td>
							</tr>
							<tr>
							  <td> Tipo Contrato: </td>
							  <td> 
								<select name="tipo_contrato" id="tipo_contrato" style="width: 300px;" class="form-control form-control-sm">	
									<option value="OBRAS" <?php if($prestadores[0]->tipo_contrato == "OBRAS") { echo 'selected'; } ?>> OBRAS </option>
									<option value="SERVIÇOS" <?php if($prestadores[0]->tipo_contrato == "SERVIÇOS") { echo 'selected'; } ?>> SERVIÇOS </option>
									<option value="AQUISIÇÃO" <?php if($prestadores[0]->tipo_contrato == "AQUISIÇÃO") { echo 'selected'; } ?>> AQUISIÇÃO </option>
								</select>
							  </td>
							</tr>
							<tr>
							  <td> Tipo Pessoa: </td>
							  <td> 
								<select name="tipo_pessoa" id="tipo_pessoa" style="width: 300px;" class="form-control form-control-sm">	
									<option value="PESSOA FÍSICA" <?php if($prestadores[0]->tipo_pessoa == "PESSOA FÍSICA") { echo 'selected'; } ?>> PESSOA FÍSICA </option>
									<option value="PESSOA JURÍDICA" <?php if($prestadores[0]->tipo_pessoa == "PESSOA JURÍDICA") { echo 'selected'; } ?>> PESSOA JURÍDICA </option>
								</select>
							  </td>
							</tr>
						</table>	
							
						<table>
							<tr>
							   <td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							   <td> <input hidden type="text" class="form-control form-control-sm" id="tela" name="tela" value="contratacaoPrestador" /> </td>
							   <td> <input hidden type="text" class="form-control form-control-sm" id="acao" name="acao" value="salvarContratacaoPrestador" /> </td>
							   <td> <input hidden type="text" class="form-control form-control-sm" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
							</tr>
						</table>
							
						<table>	
							<tr>
							  <td align="left"> <br /><br /> <a href="{{route('prestadorLista', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
							  <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> </td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>							
	</div>
</div>
@endsection