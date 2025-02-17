@extends('navbar.default-navbar')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($errors->any())
      <div class="alert alert-success">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
	@endif 
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
  <div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <h3 style="font-size: 18px;">CERTIFICADO DO PROGRAMA DE INTEGRIDADE</h3>
        </div>
    </div>
    <div class="row mt-3 text-center">
        <div class="col-md-12">
            <a class="btn btn-warning btn-sm m-2" href="{{route('transparenciaIntegridade', $unidade->id)}}" id="Voltar" name="Voltar" type="button" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>
            <a class="btn btn-dark btn-sm m-2" href="{{route('novoCI', $unidade->id)}}"> <b>Novo</b> <i class="fas fa-check"></i></a>
        </div>
    </div>
	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <div class="form-control mt-3" style="color:black">
      <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
       @foreach($integridade as $intg)
        <div class="col-md-10 mr-2">
          <h6 style="font-size: 16px;">{{ $intg->name }}</h6>
				</div>
				<div class="col-md-8 mr-2">
          <a href="{{asset('storage/')}}/{{$integridade[0]->path_file}}" target="_blank" class="btn btn-success btn-sm"><b>Download</b><i class="bi bi-download"></i></a>
            @if($intg->status_integridade == 0)
              <a title="Ativar" href="{{route('telaInativarCI', array($unidade->id,$intg->id))}}" class="btn btn-success btn-sm"> <i class="fas fa-times-circle"></i></a>
            @else
              <a title="Inativar" href="{{route('telaInativarCI', array($unidade->id,$intg->id))}}" class="btn btn-warning btn-sm"> <i class="fas fa-times-circle"></i></a>
            @endif
			  </div>          
       @endforeach
      </div>
    </div>
 </div>
</div>
@endsection
