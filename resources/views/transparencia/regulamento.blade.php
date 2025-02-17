@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$undOss[0]->name}}</strong></div>
<div class="container-fluid" >
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">REGULAMENTOS PRÓPRIOS</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 16) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)	
				 <p align="right"><a href="{{route('cadastroRG', $idund)}}" class="btn btn-info btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <b>Alterar</b> <i class="fas fa-edit"></i> </a></p>
			   @endif
			  @endif 
			 @endforeach 
			@endif
		</div>
	</div>	
	<div id="tabs" class="nav-tabs card p-4">
		<div class="row">
			<div class="col-sm-5">
				<h6 class="text-center mb-4">Setores</h6>
				<ul class="nav nav-pills mb-5" id="pills-tab" role="tablist" style="display: block !important; border:solid 3px; border-radius:5px; overflow: auto; height: 400px;">
					@foreach($setores as $setor)
						<li class="nav-item">
							<a class="nav-link" data-toggle="pill" href="#tabs<?php echo $setor->id ?>" role="tab" aria-selected="false">{{ mb_strtoupper($setor->descricao) }}</a>
						</li>
					@endforeach
				</ul>
			</div>
			<div class="col-sm-7">
				<div class="tab-content" id="pills-tabContent" style="margin-left: 40px;">
					@foreach($setores as $setor)
						<div class="tab-pane fade" id="tabs<?php echo $setor->id;?>">
							<h6 class="text-center mb-4">POP's <?php echo $setor->descricao; ?></h6>
							<div class="row">
								@foreach($manuais as $manual)
									@if($manual->setor_id == $setor->id)
										<div class="col">
											<div class="wow fadeInUp" data-wow-delay="0.2s">
												<center>
													<div class="card-group">
														<div class="card border-0" style="max-width: 12rem; background-color: #fafafa;">
															<a target="_blank" href="{{asset('storage')}}/{{$manual->path_file}}">
																<img class="card-img-top border border-secondary" src="{{asset('img')}}/{{$manual->path_img}}" alt="Card image cap" style="width: 140px; height: 200px;">
															</a>
															<center><p style="font-size: 11px; color: black;"><small>{{$manual->title}}</small></p></center>
														</div>
													</div>
												</center>
											</div>
										</div>
									@endif
								@endforeach
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
<blockquote class="blockquote" style="margin-top: 60px;">
	<footer class="blockquote-footer">Clique no regulamento para visualizar!</footer>
</blockquote>
@endsection