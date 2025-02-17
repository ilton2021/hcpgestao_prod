@extends('layouts.app')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP Gest&atilde;o</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">        
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
        </div>
        <div class="col-md-3" style="background-image: linear-gradient(to right, #28a745, #28a745); height: auto; border-radius: 175px 175px 175px 175px;">
            
        </div>
    </div>
</div>

  <div class="container">
        <div class="row">
            <div class="col-sm-12">
			@if ($errors->any())
			<div class="alert alert-success">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
	        @endif
            </div>
            <div class="col-sm-4"> </div>
        </div>
    </div>

 <section id="unidades">
    <div class="container" style="margin-top:30px; margin-bottom:20px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">ESCOLHA UMA OPÇÃO</h3></span>
            </div>
        </div>
        <div class="row">
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            <div class="col-2 text-center"></div>
            <div class="col-5">
                <div class="progress" style="height: 3px;">
                    <div  class="progress-bar" role="progressbar" style="width: 100%; background-color: #65b345;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <center>
	<div class="container d-flex justify-content-between">
        <div class="row"> 
            <table class="table table-sm" style="align-items: center; display: flex; text-align: center; justify-content: center; margin-left: 50px;">
                <tr> 
                 <td>
                  <center>
                    <img id="img-unity" src="{{asset('img/transparencia.png')}}" class="rounded-sm" alt="..." style="width:250px; height: 100px;" title="PORTAL DA TRANSPARÊNCIA">
                    <div class="card-body text-center">
                      <a href="{{ route('home') }}" class="btn btn-outline-success">Clique Aqui</a>
                    </div>
                  </center>
                 </td>
                 <td>
                  <center>
                    <img id="img-unity" src="{{asset('img/compras.jpg')}}" class="rounded-sm" alt="..." style="width:250px; height: 100px;" title="ORDEM DE COMPRAS">
                    <div class="card-body text-center">
                      <a href="{{ route('homeCompras') }}" class="btn btn-outline-success">Clique Aqui</a>
                    </div>
                  </center>
                 </td>
                 <td>
                  <center>
                    <img id="img-unity" src="{{asset('img/ocorrencias.jpg')}}" class="rounded-sm" alt="..." style="width:250px; height: 100px;" title="FORMULÁRIO DE OCORRÊNCIAS">
                    <div class="card-body text-center">
                      <a href="{{ route('indexOcorrencia') }}" class="btn btn-outline-success">Clique Aqui</a>
                    </div>
                  </center>
                 </td>
                 <td>
                  <center>
                    <img id="img-unity" src="{{asset('img/documentos.jpg')}}" class="rounded-sm" alt="..." style="width:250px; height: 100px;" title="CADASTRO DE DOCUMENTOS">
                    <div class="card-body text-center">
                      <a href="{{ route('cadastroDocumentalUnidade') }}" class="btn btn-outline-success">Clique Aqui</a>
                    </div>
                  </center>
                 </td>
                </tr> 
                <tr>
                <td>
                  <center>
                    <img id="img-unity" src="{{asset('img/contratos.png')}}" class="rounded-sm" alt="..." style="width:250px; height: 100px;" title="CADASTRO DE DOCUMENTOS">
                    <div class="card-body text-center">
                      <a href="{{ route('homeContratos') }}" class="btn btn-outline-success">Clique Aqui</a>
                    </div>
                  </center>
                 </td>
                </tr>
            </table> 
        </div> 
    </div>
    </center>
    </section >    
@endsection