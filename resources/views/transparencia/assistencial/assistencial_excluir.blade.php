@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">EXCLUIR RELATÓRIO ASSISTENCIAL:</h5>
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
	<div class="d-flex flex-column">
		<div class="card">
			<a class="form-control text-center bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
				RELATÓRIO ASSISTENCIAL: <i class="fas fa-check-circle"></i>
			</a>
		</div>

		<form action="{{\Request::route('updateRA'), $unidade->id}}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="d-inline-flex mt-2 flex-wrap align-items-center justify-content-center text-center form-control">
				<div class="p-2">
					<b>Indicador:</b>
				</div>
				<div class="p-2">
					<select id="indicador_id" name="indicador_id" class="form-control form-control-sm" onchange="exibir_ocultar(this)" readonly>
						<option value="1"> 1. Consultas Médicas </option>
						<option value="2"> 2. Comissão de Controle </option>
					</select>
				</div>
				<div class="p-2">
					<b>Ano de Referência:</b>
				</div>
				<div class="p-2">
					<input type="text" id="ano_ref" name="ano_ref" value="<?php echo $anosRef[0]->ano_ref; ?>" readonly class="form-control form-control-sm" required value="" />
				</div>
			</div>
			<div class="mt-3 justify-content-center" style="max-width:163vh; overflow:auto;">
				<table class="table table-sm ">
					<thead class="bg-success">
						<tr>
							<th scope="col"><center>Descrição</th>
							<th scope="col"><center>Meta</center></th>
							<th scope="col"><center>Janeiro</center></th>
							<th scope="col"><center>Fevereiro</center></th>
							<th scope="col"><center>Março</center></th>
							<th scope="col"><center>Abril</center></th>
							<th scope="col"><center>Maio</center></th>
							<th scope="col"><center>Junho</center></th>
							<th scope="col"><center>Julho</center></th>
							<th scope="col"><center>Agosto</center></th>
							<th scope="col"><center>Setembro</center></th>
							<th scope="col"><center>Outubro</center></th>
							<th scope="col"><center>Novembro</center></th>
							<th scope="col"><center>Dezembro</center></th>
						</tr>
					</thead>
					@foreach($anosRef as $aRef)
					<tbody>
						<tr>
							<th> <input type="text" id="descricao" name="descricao" title="<?php echo $aRef->descricao; ?>" value="<?php echo $aRef->descricao; ?>" class="form-control form-control-sm" style="width: 350px" readonly /> </td>
							<th> <input type="text" id="meta" name="meta" title="<?php echo $aRef->meta; ?>" value="<?php echo $aRef->meta; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </td>
							<th> <input type="text" id="janeiro" name="janeiro" title="<?php echo $aRef->janeiro; ?>" value="<?php echo $aRef->janeiro; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="fevereiro" name="fevereiro" title="<?php echo $aRef->fevereiro; ?>" value="<?php echo $aRef->fevereiro; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="marco" name="marco" title="<?php echo $aRef->marco; ?>" value="<?php echo $aRef->marco; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="abril" name="abril" title="<?php echo $aRef->abril; ?>" value="<?php echo $aRef->abril; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="maio" name="maio" title="<?php echo $aRef->maio; ?>" value="<?php echo $aRef->maio; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="junho" name="junho" title="<?php echo $aRef->junho; ?>" value="<?php echo $aRef->junho; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="julho" name="julho" title="<?php echo $aRef->julho; ?>" value="<?php echo $aRef->julho; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="agosto" name="agosto" title="<?php echo $aRef->agosto; ?>" value="<?php echo $aRef->agosto; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="setembro" name="setembro" title="<?php echo $aRef->setembro; ?>" value="<?php echo $aRef->setembro; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="outubro" name="outubro" title="<?php echo $aRef->outubro; ?>" value="<?php echo $aRef->outubro; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="novembro" name="novembro" title="<?php echo $aRef->novembro; ?>" value="<?php echo $aRef->novembro; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
							<th> <input type="text" id="dezembro" name="dezembro" title="<?php echo $aRef->dezembro; ?>" value="<?php echo $aRef->dezembro; ?>" class="form-control form-control-sm" style="width: 100px" readonly /> </th>
						</tr>
					</tbody>
					@endforeach
					<table>
						<tr>
							<td> <input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="relAssistencial" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarRelAssistencial" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>
				</table>
			</div>
			<div class="mt-4 text-start">
				<h6> Deseja realmente Excluir este Relatório Assistencial?? </h6>
			</div>
			<table>
				<tr>
					<td align="left">
						<a href="{{route('cadastroRA', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
						<input type="submit" class="btn btn-danger btn-sm" style="margin-top: 10px;" value="Excluir" id="Excluir" name="Excluir" />
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
@endsection