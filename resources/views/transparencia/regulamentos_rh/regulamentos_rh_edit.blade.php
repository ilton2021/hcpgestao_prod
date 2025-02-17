@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
	<div class="col-md-12 text-center">
                <h4>Recursos Humanos</h4>
                <h5>Alteração Regulamento</h5>
            </div>
	</div>
	@if($errors->any())
	<div class="alert alert-danger" style="font-size:16px;">
		<ul class="list-unstyled">
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@elseif(isset($sucesso))
    	@if($sucesso =="ok")
    	<div class="alert alert-success" style="font-size:16px;">
    		<ul class="list-unstyled">
    			<li>{{ $validator }}</li>
    		</ul>
    	</div>
    	@endif
	@endif
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
						Alteração de Regulamento: <i class="fas fa-check-circle"></i>
					</a>
				</div> 
				<form action="{{ route('regulamentosRhUpdate', array($regulamentoRh[0]->id, $unidade->id)) }}" method="post" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<div class="form-control mt-3" style="color:black">
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Título:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" type="text" id="nome" name="nome" value="{{$regulamentoRh[0]->regulamentorh }}" required />
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
							<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-1">
									<label><strong>Mês:</strong></label>
								</div> 
								<div class="col-md-4 mr-2">
									<select class="form-control" type="text" name="mes" id="mes" required>
										<option  value="">Selecione...</option>
										<option {{$regulamentoRh[0]->mes == "1"  ? "selected" : "" }}  value="1">Janeiro</option>	
										<option {{$regulamentoRh[0]->mes == "2"  ? "selected" : "" }} value="2">Fevereiro</option>	
										<option {{$regulamentoRh[0]->mes == "3"  ? "selected" : "" }} value="3">Março</option>	
										<option {{$regulamentoRh[0]->mes == "4"  ? "selected" : "" }} value="4">Abril</option>	
										<option {{$regulamentoRh[0]->mes == "5"  ? "selected" : "" }} value="5">Maio</option>	
										<option {{$regulamentoRh[0]->mes == "6"  ? "selected" : "" }} value="6">Junho</option>	
										<option {{$regulamentoRh[0]->mes == "7"  ? "selected" : "" }} value="7">Julho</option>	
										<option {{$regulamentoRh[0]->mes == "8"  ? "selected" : "" }} value="8">Agosto</option>	
										<option {{$regulamentoRh[0]->mes == "9"  ? "selected" : "" }} value="9">Setembro</option>	
										<option {{$regulamentoRh[0]->mes == "10" ? "selected" : "" }} value="10">Outubro</option>	
										<option {{$regulamentoRh[0]->mes == "11" ? "selected" : "" }} value="11">Novembro</option>	
										<option {{$regulamentoRh[0]->mes == "12" ? "selected" : "" }} value="12">Dezembro</option>	
									</select>
								</div>
								<div class="col-md-2 mr-0">
									<label><strong>Ano:</strong></label>
								</div> <?php $ano = date("Y", strtotime('now')); ?>
								<div class="col-md-4 mr-0">
									<select class="form-control" type="text" name="ano" id="ano" required>
                                        @php
                                            $anoInicial = 2000; // Ano inicial desejado
                                            $anoFinal = 2040; // Ano final desejado
                                        @endphp
                                        @for ($ano = $anoInicial; $ano <= $anoFinal; $ano++)
                                            <option {{ $regulamentoRh[0]->ano == $ano ? "selected" : "" }} value="{{ $ano }}">{{ $ano }}</option>
                                        @endfor
                                    </select>
								</div>
							</div>
						</div>
						<div class="form-row mt-2">
						    <div class="form-group col-md-6 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-4 mr-2">
									<label><strong>Arquivo Atual:</strong></label>
								</div>
							<div class="col-md-8 d-sm-flex justify-content-start">
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#pdfModal">Visualizar</button>
                            </div>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="pdfModalLabel">Visualização de arquivo</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <iframe src="{{asset('storage')}}/{{$regulamentoRh[0]->file_path}}" width="100%" height="400vh" frameborder="0"></iframe>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

							</div>
							<div class="form-group col-md-6 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
								<div class="col-md-2 mr-2">
									<label><strong>Arquivo Novo:</strong></label>
								</div>
								<div class="col-md-10 mr-2">
									<input class="form-control" type="file" name="file_path" id="file_path" />
								</div>
							</div>
						</div>
					</div>
					<table>
						<tr>
							<td> <input hidden style="width: 100px;" type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
							<td> <input hidden type="text" class="form-control" id="registro_id" name="registro_id" value="" /> </td>
							<td> <input hidden type="text" class="form-control" id="tela" name="tela" value="NovajustificativaRegulaRh" /> </td>
							<td> <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarjustificativaRegulaR" /> </td>
							<td> <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> </td>
						</tr>
					</table>

					<div class="d-flex justify-content-between">
						<div>
							<a href="javascript:history.back();" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
						</div>
						<div>
							<input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection