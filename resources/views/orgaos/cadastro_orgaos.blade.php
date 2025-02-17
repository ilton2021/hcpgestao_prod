@extends('layouts.app')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <link rel="stylesheet" type="text/css" href="resourcers\views\ordem_compra\style.css" media="screen" />
        <title>Portal da Transparencia - HCP</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>
@section('content')
    @if ($errors->any())
			<div class="alert alert-success">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
	@endif
 
 <section id="unidades">
 <table>   
    <tr> 
        <td> 
          <a class="btn btn-warning btn-sm" class="form-control" style="color: #FFFFFF; margin-left: 200px; margin-bottom: 15px; height: 30px;" href="{{route('cadastroDocumentalLista', $unidade->id)}}"> Voltar <i class="fas fa-undo-alt"></i></a>     
        </td>
        <td>  
          <a class="btn btn-dark  btn-sm" class="form-control" style="color: #FFFFFF; margin-left: 960px; margin-bottom: 15px; height: 28px;" href="{{route('novoORG', $unidade->id)}}" > Novo <i class="fas fa-check"></i></a>    
        </td>
    </tr>
  </table>       
    <div class="container" style="margin-top:05px; margin-bottom:10px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">ÓRGÃOS</h3></span>
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
    <div class="container d-flex justify-content-between">
     <form action = "{{ route('pesquisaOrgaos', $unidade->id) }}" method="POST"> 
     <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
      <table class="table table-sm" style="margin-left: 250px;">
        <tr>    
            <td> 
                <select class="custom-select mr-sm-2" id="funcao2" name="funcao2">
                  <option id="funcao2" name="funcao2" value="0">Selecione...</option>
                  <option id="funcao2" name="funcao2" value="1">Nome</option>
                </select> 
            </td>     
            <td>
                <input id="text" name="text" type="text" class="form-control" placeholder="...">
            </td>
            <td>
                <button type="submit" class="btn btn-primary" style="margin-right: 35px; height: 35px;" >Pesquisar  <i class="fas fa-search"></i></button>
            </td>
        </tr> 
      </table>
      </form> 
    </div>
	<div class="container d-flex justify-content-between">
        <div class="row">
            <table class="table table-striped table-sm table-bordered" style="margin-left: -100px; width: 1340px;">
              
                <thead>
                 <tr>
                    <td style="font-size: 13px"><b> <center>Nome</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Alterar</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Excluir</center> </b></td>
                  </tr>
                 </thead>
                   @foreach($orgaos as $prc)
                   <tr>
                    <td style="font-size: 13px;" title="<?php echo $prc->nome; ?>"><center> {{ $prc->nome }} </center></td>
                    <td> <center> <a title="Alterar" class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{ route('alterarORG', array($unidade->id, $prc->id)) }}"> <i class="fas fa-edit"></i></a> </center> </td>
                    <td> <center> <a title="Excluir" class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{route('telaInativarORG', array($unidade->id, $prc->id))}}"><i class="fas fa-times-circle"></i></a> </center> </td>
                   </tr> 
                   @endforeach   
            </table>
            <table>
             <tr><td> {{ $orgaos->appends(['pesq' => isset($pesq) ? $pesq : ''])->render() }} </td></tr>
            </table>
        </div>
    </div>
</section >    
@endsection