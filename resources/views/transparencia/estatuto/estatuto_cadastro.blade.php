@extends('navbar.default-navbar')
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    @if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
  <div class="d-flex flex-column text-center mt-3">
	<h5 style="font-size: 16px;">ESTATUTO SOCIAL E ATAS DO ESTATUTO SOCIAL</h5>
	<div class="d-inline-flex justify-content-around">
		<div class="p-2">
			<a href="{{route('transparenciaEstatuto', $unidade->id)}}" class="btn btn-warning btn-sm " style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
		</div>
		<div class="p-2">
			<a href="{{route('novoES', $unidade->id)}}" class="btn btn-dark btn-sm" style="color: #FFFFFF;"> <b>Novo</b> <i class="fas fa-check"></i> </a>
		</div>
	</div>
	<div class="row"> 
		<div class="col-md-8 offset-md-2 text-center">
			<ul class="list-group">
			<br>
				<p>
				  <a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#atas" role="button" aria-expanded="false" aria-controls="collapseExample">
					ATAS <i class="fas fa-book"></i>
				  </a>
				  <a style="width:200px;" class="btn btn-success" data-toggle="collapse" href="#estatutos" role="button" aria-expanded="false" aria-controls="collapseExample">
				    ESTATUTOS <i class="fas fa-book"></i>
				  </a>
				</p>

				<div class="collapse border-0" id="atas">
				  <div class="card card-body border-0"> 
				    @foreach($estatutos as $estatuto)
				     @if($estatuto->kind == "ATA")  
				  	  <li class="list-group-item d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center border-top" style="background-color: #fafafa">
						<div  style="font-size: 14px;">
						 <center>
						  <strong>{{$estatuto->year}} - </strong>
						  <strong>{{$estatuto->name}} </strong> &nbsp;&nbsp;&nbsp;&nbsp;
						  <a href="{{asset('storage')}}/{{$estatuto->path_file}}" target="_blank" class="btn btn-success btn-sm"><b>Download</b> <i class="fas fa-file-download"></i></a> &nbsp;&nbsp;&nbsp;
    			  		   @if($estatuto->status_estatuto == 0)
						    <a title="Ativar" class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarES', array($unidade->id, $estatuto->id))}}"><i class="fas fa-times-circle"></i></a> 
						   @else
						    <a title="Inativar" class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarES', array($unidade->id, $estatuto->id))}}"><i class="fas fa-times-circle"></i></a> 
						   @endif 
						 </center>
						</div>
					  </li>
					 @endif
					@endforeach
				  </div> 
				</div>

				<div class="collapse border-0" id="estatutos">
				 @foreach($estatutos as $estatuto)
				  @if($estatuto->kind  == "EST")
				   <div class="card card-body border-0"> 
					<li class="list-group-item d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center border-top" style="background-color: #fafafa">
					  <div>
    			 		<strong>{{$estatuto->year}} - </strong>
					 	<strong>{{$estatuto->name}} </strong> &nbsp;&nbsp;&nbsp;&nbsp;
						<a href="{{asset('storage')}}/{{$estatuto->path_file}}" target="_blank" class="btn btn-success btn-sm"><b>Download</b> <i class="fas fa-file-download"></i></a> &nbsp;&nbsp;&nbsp;
					    @if($estatuto->status_estatuto == 0)
					     <a title="Ativar" class="btn btn-success btn-sm" style="color: #000000;" href="{{route('telaInativarES', array($unidade->id, $estatuto->id))}}"><i class="fas fa-times-circle"></i></a>
					    @else
					     <a title="Inativar" class="btn btn-warning btn-sm" style="color: #000000;" href="{{route('telaInativarES', array($unidade->id, $estatuto->id))}}"><i class="fas fa-times-circle"></i></a>
					    @endif
					  </div>
    			  	</li>
				   </div> 
				  @endif
    			 @endforeach
				</div>
			</ul>
		</div>
	</div>
</div>
@endsection