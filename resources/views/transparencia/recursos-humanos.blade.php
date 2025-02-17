@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;">RECURSOS HUMANOS</h3>
		</div>
	</div>
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-1 col-sm-0"></div>
		<div class="col-md-10 col-sm-12 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL" style="cursor: pointer;">
						SELEÇÃO DE PESSOAL<i class="fas fa-check-circle"></i>
					</a>
					<div id="PESSOAL" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					@if(Auth::check())
					 @foreach ($permissao_users as $permissao)
					  @if(($permissao->permissao_id == 12) && ($permissao->user_id == Auth::user()->id))
					   @if ($permissao->unidade_id == $unidade->id)	
						<br /><a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroSP', $unidade->id)}}" > Alterar <i class="fas fa-edit"></i></a>
					   @endif	
					  @endif	
                     @endforeach					  
					@endif
					<div class="card-body" style="background-color: #fafafa">
						@foreach ($selecaoPessoal->pluck('ano')->unique()->toArray() as $ano)
							<p>
								<div class="row">
									<div class="container">
										<a class="btn btn-success btn-sm" data-toggle="collapse" href="#{{$ano}}" role="button" aria-expanded="false" aria-controls="{{$ano}}">
											Seleção - {{$ano}} <i class="fas fa-user-md"></i> <i class="fas fa-user-tie"></i>
										</a>
									</div>
								</div>
							</p>
						  <div class="collapse border-0" id="{{$ano}}">
							<div class="card border-0 card-body">
								<table class="table table-success table-sm" style="font-size: 13px;">
									<thead class="bg-success">
									  <tr>
										<th scope="col">Cargo</th>
										<th scope="col">Quantidade</th>
									  </tr>
									</thead>
									<tbody>
										@foreach ($selecaoPessoal as $selecao)
										@if ($selecao->ano === $ano)
											<tr>
												<td>{{$selecao->nome}}</td>
												<td>{{$selecao->quantidade}}</td>
											</tr>

										@endif
										@endforeach
										<tr>
											<td><strong>Total</strong></td>
											<td><strong>{{$selecaoPessoal->where('ano', $ano)->pluck('quantidade')->sum()}}</strong></td>
										</tr>
									</tbody>
								</table>
							</div>
						  </div>
						@endforeach												
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y", strtotime($ultimaAtualiza))}}</small></p>
					</div>
					</div>
				</div>
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#SELETIVO" aria-expanded="true" aria-controls="SELETIVO" style="cursor: pointer;">
						PROCESSO SELETIVO <i class="fas fa-tasks"></i>
					</a>				
					<div id="SELETIVO" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					@if(Auth::check())
					 @foreach ($permissao_users as $permissao)
					  @if(($permissao->permissao_id == 12) && ($permissao->user_id == Auth::user()->id))
					   @if ($permissao->unidade_id == $unidade->id)	
						<br /><a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{route('cadastroPS', $unidade->id)}}" > Alterar <i class="fas fa-edit"></i></a>
					   @endif
					  @endif 
					 @endforeach 
					@endif
					<div class="card-body border-0" style="background-color: #fafafa">
						<p>
							@foreach ($docSelectiveProcess->pluck('year')->unique() as $ano)
								<a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}SELETIVO" role="button" aria-expanded="false" aria-controls="{{$ano}}SELETIVO">{{$ano}}</a>
							@endforeach
						</p>
						@foreach ($docSelectiveProcess->pluck('year')->unique() as $ano)
						<div class="collapse border-0" id="{{$ano}}SELETIVO" >
							<div class="card border-0 card-body" style="background-color: #fafafa">
								<h6 class=""><strong>{{$ano}}</strong></h6>
								<table class="table table-success border border-rounded">
									<tbody>
										@foreach ($docSelectiveProcess->sortBy('ordering') as $item)
										@if ($item->year === $ano)
											<tr>
												<td style="font-size: 10px;" class="text-left border-0" >{{$item->title}}</td>
												<td class="border-0"><i class="fas fa-arrow-right"></i></td>
												<td class="border-0"><a target="_blank" href="{{asset('storage')}}/{{$item->file_path}}" class="badge badge-success">Visualizar</a></td>
											</tr>
										@endif
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
						@endforeach						
						@if($unidade->id != 8)
						<h6 class=""><strong><a href="https://concursos.promunicipio.com/informacoes/264/" target="_blank"> Pró-Município - Processo Seletivo HCPGESTÃO 2019</a></strong></h6>						
						@endif
						@if($unidade->id == 2)
						<h6 class=""><strong><a href="http://hcp.org.br/processoseletivo/" target="_blank"> Incrições Processo Seletivo 09.2017 (encerrado)</a></strong></h6>
						<h6 class=""><strong><a href="http://hcp.org.br/hmr/" target="_blank"> Site de Acompanhamento do Processo Seletivo HMR</a></strong></h6>
						@endif
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y", strtotime($docSelectiveProcess->max('updated_at')))}}</small></p>
					</div>
					</div>
				</div>
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#DESPESAS" aria-expanded="true" aria-controls="DESPESAS" style="cursor: pointer;">
					DESPESAS COM PESSOAL <i class="fas fa-book"></i>
					</a>
					<div id="DESPESAS" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					<div class="card-body" style="font-size: 15px;background-color: #fafafa;">
						<i style="margin-right: 5px;" class="fas fa-scroll"></i>Despesas com Pessoal
						@if(Auth::check())
						<a style="margin-left:10px;" class="btn btn-success btn-sm" href="{{ route('despesasRH', array($unidade->id)) }}" role="button">Consultar<i style="margin-left:5px;" class="fas fa-edit"></i></a>
						@else
						<a style="margin-left:10px;" class="btn btn-success btn-sm" href="{{ route('despesasUsuarioRH', array($unidade->id)) }}" role="button">Consultar<i style="margin-left:5px;" class="fas fa-edit"></i></a>
						@endif
					    </i>	
					</div>
					</div>
				</div>
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#CEDIDOS" aria-expanded="true" aria-controls="CEDIDOS" style="cursor: pointer;">
						SERVIDORES PÚBLICOS CEDIDOS <i class="fas fa-sync-alt"></i>
					</a>	
					<div id="CEDIDOS" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					@if(Auth::check())	
					 @foreach ($permissao_users as $permissao)
					  @if(($permissao->permissao_id == 12) && ($permissao->user_id == Auth::user()->id))
					   @if ($permissao->unidade_id == $unidade->id)	
						<br /><a class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{ route('cadastroSE', $unidade->id) }}" > Alterar <i class="fas fa-edit"></i></a>
					   @endif
					  @endif
                     @endforeach 					  
					@endif
					@if($unidade->id !== 8) 
					<div class="row" style="margin-top: 25px;">
					  <div class="col-md-2 col-sm-0"></div>
						<div class="col-md-8 col-sm-12 text-center">
							<b>JUSTIFICATIVA:</b> <br><br>
							@foreach ($justificativa->pluck('ano')->unique() as $ano)
							 <a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}CEDIDOS" role="button" aria-expanded="false" aria-controls="{{$ano}}CEDIDOS"> {{$ano}}</a>
							@endforeach
							@foreach ($justificativa->pluck('ano')->unique() as $justificativaR)
							<div class="collapse border-0" id="{{$justificativaR}}CEDIDOS">
								<div class="card card-body border-0" style="background-color: #fafafa">
									@foreach ($justificativa as $item)
									 @if ($item->ano == $justificativaR)
									  <div class="table table-success border border-rounded border-success" style="font-size: 15px;padding: 2px 2px; width: 500px;">
										<a href="{{asset('storage')}}/{{$item->caminho}}" target="_blank" style="padding: 5px 5px;">{{$item->nome}} - <span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span> 
										  <i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
										</a>
									  </div>
									 @endif	
									@endforeach
								</div>
							</div>
							<div class="card-body" style="font-size: 15px;background-color: #fafafa;">
        					  <p class="card-text"><small class="text-muted"><b>Última atualização:</b> {{date("d/m/Y", strtotime($item->updated_at))}}</small></p>
        					</div>
							@endforeach
						</div>
					  <div class="col-md-2 col-sm-0"></div>
					</div>
					@else
					<div class="card-body" style="background-color: #fafafa">
					<table class="table table-sm" id="my_table">
							<thead class="bg-success">
								<tr>
									<th scope="col">Nome</th>
									<th scope="col">Cargo</th>
									<th scope="col">Matrícula</th>
									<th scope="col">Data Início</th>
								</tr>
							</thead>
							<tbody>				
								@foreach($servidores as $servidor)
								 <tr>
									<td style="font-size: 11px;">{{$servidor->nome}}</td>
									<td style="font-size: 11px;">{{$servidor->cargo}}</td>
									<td style="font-size: 11px;">{{$servidor->matricula}}</td>
									<td style="font-size: 11px;">{{date('d-m-Y',strtotime($servidor->data_inicio))}}</td>
								 </tr>
								@endforeach
							</tbody>
						   </table>
					</div>
					@endif
				  </div>
				</div>	
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#REGULAMENTO" aria-expanded="true" aria-controls="REGULAMENTO" style="cursor: pointer;">
					REGULAMENTO <i class="fas fa-book"></i>
					</a>
					<div id="REGULAMENTO" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					@if(Auth::check())
					 @foreach ($permissao_users as $permissao)
					  @if(($permissao->permissao_id == 12) && ($permissao->user_id == Auth::user()->id))
					   @if ($permissao->unidade_id == $unidade->id)	
						  <br /><a class="btn btn-info btn-sm m-1" style="color: #FFFFFF;" href="{{ route('regulamentosRhCadastros', $unidade->id) }}" > Alterar <i class="fas fa-edit"></i></a-->
						  <br /><a class="btn btn-dark btn-sm m-1" style="color: #FFFFFF;" href="{{route('novoJS', array($unidade->id, 4))}}" > Justificar <i class="fas fa-edit"></i></a>
					   @endif
					  @endif 
					 @endforeach 
					@endif
					@if(sizeof($regulamentosRh) > 0)
					<div class="responsive" style="margin-top: 25px;">
						<table class="table table-success">
						    <tbody>
						    @foreach($regulamentosRh as $regulamentoRh)    
						        <tr>
						            <td>{{$regulamentoRh->regulamentorh}}</td>
						            <td><a target="_blanck" href="{{asset('storage')}}/{{$regulamentoRh->file_path}}" type="button" class="btn btn-success"><i class="bi bi-eye-fill"></i> Visualizar</a> </td>
						        </tr>
						    @endforeach
						    </tbody>
						</table>
					</div>
					@endif
					
					@if(sizeof($justificativaRegulamentoRh) > 0)
					<div class="row" style="margin-top: 25px;">
					  <div class="col-md-2 col-sm-0"></div>
						<div class="col-md-8 col-sm-12 text-center">
							<b>JUSTIFICATIVA:</b> <br><br>
							@foreach ($justificativaRegulamentoRh->pluck('ano')->unique() as $ano)
							 <a class="btn btn-success" data-toggle="collapse" href="#{{$ano}}regulamento" role="button" aria-expanded="false" aria-controls="{{$ano}}regulamento"> {{$ano}}</a>
							@endforeach
							@foreach ($justificativaRegulamentoRh->pluck('ano')->unique() as $justificativaR)
							<div class="collapse border-0" id="{{$justificativaR}}regulamento">
								<div class="card card-body border-0" style="background-color: #fafafa">
									@foreach ($justificativaRegulamentoRh as $item)
									 @if ($item->ano == $justificativaR)
									  <div class="list-group" style="font-size: 15px;padding: 2px 2px; width: 500px;">
										<a href="{{asset('storage')}}/{{$item->caminho}}" target="_blank" class="list-group-item list-group-item-action" style="padding: 5px 5px;">{{$item->nome}} - <span class="badge badge-secondary">{{$item->mes}}/{{$item->ano}}</span> 
										  <i style="color:#65b345" class="fas fa-cloud-download-alt"></i> 
										</a>
									  </div>
									 @endif	
									@endforeach
								</div>
							</div>
							<div class="card-body" style="font-size: 15px;background-color: #fafafa;">
        					  <p class="card-text"><small class="text-muted"><b>Última atualização:</b> {{date("d/m/Y", strtotime($item->updated_at))}}</small></p>
        					</div>
							@endforeach
						</div>
					  <div class="col-md-2 col-sm-0"></div>
					</div>
					@else
					<div class="card-body" style="font-size: 15px;background-color: #fafafa;">
						<p class="card-text"><small class="text-muted">Última atualização {{date("d/m/Y")}}</small></p>
					</div>
					@endif
					</div>
				</div>
			</div>
        </div>
		<div class="col-md-1 col-sm-0"></div>
    </div>
</div>
@endsection