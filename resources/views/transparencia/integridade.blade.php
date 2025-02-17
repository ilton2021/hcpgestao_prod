@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
<div class="container-fluid">
	<div class="row mb-2" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h5 style="font-size: 18px;">CERTIFICADO DO PROGRAMA DE INTEGRIDADE</h5>
			@if(Auth::check())
			 @foreach ($permissao_users as $permissao)
			  @if(($permissao->permissao_id == 3) && ($permissao->user_id == Auth::user()->id))
			   @if ($permissao->unidade_id == $unidade->id)
			    <div class="d-flex mt-4 justify-content-center">
				 <p align="right"><a href="{{ route('cadastroCI', $unidade->id) }}" class="btn btn-info btn-sm" style="color: #FFFFFF;"> <b>Alterar</b> <i class="fas fa-edit"></i></a></p>
			    </div>
			   @endif
			  @endif
		 	 @endforeach
			@endif
		</div>
	</div>
	
	<div class="row mt-3">
		<div class="col-md-12">
			<div class="d-flex m-2" style="overflow:auto;align:center;">
				<div class="d-inline-flex flex-wrap justify-content-center text-center">
					
				</div>
			</div>
		 </div>
	</div>
</div>

<div class="container text-center" style="margin-top: 15px;">
 @foreach($integridade as $int) 
  <a class="text-success" target="_blank" href="{{asset('storage/')}}/{{$integridade[0]->path_file}}" title="<?php echo $int->name; ?>"><img src="{{asset('img/pdf.png')}}" alt="" width="60"><center>{{ $int->name }}</center></a> <br><br>
 @endforeach
</div>
@endsection