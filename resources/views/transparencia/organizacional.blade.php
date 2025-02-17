@extends('navbar.default-navbar')
@section('content')
<link rel="stylesheet" href="{{asset('css/bootstrap-icons.css')}}">
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row" style="margin-bottom: 25px; margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5  style="font-size: 18px;">ESTRUTURA ORGANIZACIONAL</h5>
		</div>
	</div>	
	<div class="row">
		<div class="col-md-12">
			<h3 style="font-size: 15px;"><strong>REGIMENTO INTERNO</strong></h3>
			<ul class="list-inline">
				@if(empty($reg[0]))
				<li class="list-inline-item">
					<h5 style="font-size: 12px;">Regimento Interno:</h5>
				</li>
				@else
				<li class="list-inline-item">
					<h5 style="font-size: 12px;">{{ $reg[0]->title }}</h5>
				</li>
				@endif
				@if($qtd > 0)
				<li class="list-inline-item"><a href="{{asset('storage')}}/{{$reg[0]->file_path}}" target="_blank" class="btn btn-success btn-sm"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a></li>
				@endif
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
				  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
				   @if ($permissao->unidade_id == $unidade->id)
				    <li class="list-inline-item"><a href="{{route('cadastroRE', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="bi bi-paperclip"></i> </a></li>
				   @endif
				  @endif
				 @endforeach 
				@endif
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="mt-3">
				<h3 style=" font-size: 15px;"><strong>ORGANOGRAMA</strong></h3>
				
				<h5 style=" font-size: 12px;">Estrutura Organizacional {{ stristr($unidade->name, 'Unidade') == true || stristr($unidade->name, 'Sociedade') == true ? 'da' : 'do'}} {{$unidade->name}}</h5>
            </div>
        </div>
        <div class="col-md-4 p-3">
            <div class="mt-3">
                 @if(sizeof($arqOrgano) > 0)
			        <a href="{{asset('storage')}}/{{$arqOrgano[0]->file_path}}" class="btn btn-success btn-sm" target="_blank"><i class="fas fa-file-download" style="margin-right: 5px;"></i>Download</a>
			     @endif
			
				@if(Auth::check())
				 @foreach ($permissao_users as $permissao)
				  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
				   @if ($permissao->unidade_id == $unidade->id)
    				<a href="{{route('organograma', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="bi bi-paperclip"></i> </a> </li>
    			   @endif
    			  @endif
    			 @endforeach 
				@endif
				
				@if(Auth::check())
        		 @foreach ($permissao_users as $permissao)
            	  @if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
                   @if ($permissao->unidade_id == $unidade->id)
                   	<a href="{{route('cadastroOR', $unidade->id)}}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> Alterar <i class="fas fa-edit"></i> </a>
                   @endif
            	  @endif
        		 @endforeach
    			@endif
			</div> 
		  </div>
	</div>
	<div class="row">
	  <div class="col-md-12">	
	    <div class="mt-3">
			@if(Auth::check())
    			@foreach ($permissao_users as $permissao)
        			@if(($permissao->permissao_id == 2) && ($permissao->user_id == Auth::user()->id))
            			@if ($permissao->unidade_id == $unidade->id)
            			<div class="mt-4">
				            <h3 style="font-size: 15px;"><strong>ESTRUTURA ORGANIZACIONAL</strong></h3>
			            </div>
            			@endif
        			@endif
    			@endforeach
			@endif
			@if($unidade->id > 1)
			  <div class="col-md-12 d-sm-block table-success rounded">
				<div class="d-flex flex-column">
				@foreach($estruturaOrganizacional as $organizacional)
						<div class="d-sm-inline-flex justify-content-sm-between text-sm-left">
							<div class="d-flex flex-column p-2">
							    <div style="font-size:14px;"><i class="fa fa-user" aria-hidden="true"></i> <label><b>{{$organizacional->cargo}}</b></label></div>
								<div style="font-size:14px;"><label><b>Nome</b>: {{$organizacional->name}}</label></div>
							</div>
							<div class="d-flex flex-column text-sm-right p-3">
								<div style="font-size:14px;"><label><b>Telefone:</b> {{$organizacional->telefone}}</label></div>
								<div style="font-size:14px;"><label><b>E-mail:</b> {{$organizacional->email}}</label></div>
							</div> 
						</div> 
						<div style="margin-top: -35px;"><hr></div>
				@endforeach
				</div>
			  </div>
			@endif
		</div>
	</div>
</div>
</div>
</div>

@endsection