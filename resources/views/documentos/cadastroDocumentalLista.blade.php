@extends('layouts.app')
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <link rel="stylesheet" type="text/css" href="resourcers\views\ordem_compra\style.css" media="screen" />
        <title>Portal da Transparencia - HCP GEST&Atilde;O - Cadastro de Documentos</title>
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
    <div class="container" style="margin-top:05px; margin-bottom:10px;">
        <div class="row">
            <div class="col-12 text-center">
                <a class="btn btn-warning btn-sm" class="form-control" style="color: #FFFFFF;" href="{{route('cadastroDocumentalUnidade')}}"> Voltar <i class="fas fa-undo-alt"></i></a>      
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-success btn-sm" class="form-control" style="color: #FFFFFF;" href="{{route('listarORG', $unidade[0]->id)}}"> Novo Órgão <i class="fas fa-check"></i></a>       
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-dark btn-sm" class="form-control" style="color: #FFFFFF;" href="{{route('cadastroDocumental', $unidade[0]->id)}}"> Novo <i class="fas fa-check"></i></a> 
            </div>
        </div> <br>
        <div class="row">
            <div class="col-12 text-center">
                <span><h3 style="color:#65b345; margin-bottom:0px;">DOCUMENTOS:</h3></span>
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
   <form action = "{{ route('pesquisaDocumentos', $unidade[0]->id)}}" method="POST"> 
   <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
    <table class="table table-sm" style="margin-left: 100px;">
        <tr>    
            <td> 
                <select class="custom-select mr-sm-2" id="funcao" name="funcao">
                  <option id="funcao" name="funcao" value="0">Selecione...</option>
                  <option id="funcao" name="funcao" value="1">Tipo do Documento</option>
                  <option id="funcao" name="funcao" value="2">Nome do Documento</option>
                  <option id="funcao" name="funcao" value="3">E-mail</option>
                  <option id="funcao" name="funcao" value="4">Órgão</option>
                </select> 
            </td>     
            <td>
              <input id="text" name="text" type="text" class="form-control" placeholder="...">
            </td>
            <td>
              <button type="submit" class="btn btn-primary">Pesquisar  <i class="fas fa-search"></i></button>
            </td>
        </tr>   
    </table>
    </form> 
	<div class="container d-flex justify-content-between">
        <div class="row">
            <table class="table table-striped table-sm table-bordered" style="margin-left: -100px; width: 1340px;">
                <thead>
                 <tr>
                    <td style="font-size: 13px;"><b> <center>Tipo do Documento</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Nome do Documento</center> </b></td>
                    <td style="font-size: 13px"><b> <center>E-mail</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Órgão</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Data Início</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Data Fim</center> </b></td>
                    <td style="font-size: 13px"><b> <center>Validação</center> </b></td>
                  </tr>
                 </thead>
                   @foreach($documentos as $doc)
                   <tr>
                    <td style="font-size: 13px; <?php if($doc->status == 1) { echo 'background-color: yellow'; } else if($doc->status == 2) { echo 'background-color: red'; } ?>" title="<?php echo $doc->tipo_documento; ?>" ><center><b>{{ $doc->tipo_documento }}</b></center></td>
                    <td style="font-size: 13px; <?php if($doc->status == 1) { echo 'background-color: yellow'; } else if($doc->status == 2) { echo 'background-color: red'; } ?>" title="<?php echo $doc->nome; ?>">  <center> {{ $doc->nome }} </center></td>
                    <td style="font-size: 13px; <?php if($doc->status == 1) { echo 'background-color: yellow'; } else if($doc->status == 2) { echo 'background-color: red'; } ?>" title="<?php echo $doc->email; ?>"> <center>{{ $doc->email }}</center> </td>
                    <td style="font-size: 13px; <?php if($doc->status == 1) { echo 'background-color: yellow'; } else if($doc->status == 2) { echo 'background-color: red'; } ?>" title="<?php echo $doc->orgao; ?>"><center>{{ $doc->orgao }}</center> </td>
                    <td style="font-size: 13px; <?php if($doc->status == 1) { echo 'background-color: yellow'; } else if($doc->status == 2) { echo 'background-color: red'; } ?>" title="<?php echo $doc->data_inicio; ?>"><center> {{ date('d/m/Y', strtotime($doc->data_inicio)) }} </center></td>
                    <td style="font-size: 13px; <?php if($doc->status == 1) { echo 'background-color: yellow'; } else if($doc->status == 2) { echo 'background-color: red'; } ?>" title="<?php echo $doc->data_fim; ?>"> <center>{{ date('d/m/Y', strtotime($doc->data_fim)) }}</center> </td>
                    <td> 
                      <div class="dropdown">
                        <a class="btn btn-outline-info" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fas fa-caret-down"></i>               
                        </a>
                       <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a title="Alterar" class="btn btn-info btn-sm" style="color: #FFFFFF;" href="{{ route('cadastroDocumentalAlterar', array($unidade[0]->id, $doc->id)) }}" > <i class="fas fa-edit"></i></a>
                        <a title="Cancelar" class="btn btn-warning btn-sm" style="color: #FFFFFF;" href="{{ route('alterarStatus', array($unidade[0]->id, $doc->id, 1)) }}" > <i class="fa fa-times-circle"> </i></a>
                        @if($doc->status != 2)
                        <a title="Inativar" class="btn btn-danger btn-sm" style="color: #FFFFFF;" href="{{ route('alterarStatus', array($unidade[0]->id, $doc->id, 2)) }}" > <i class="fa fa-times-circle"> </i></a>
                        @else
                        <a title="Ativar" class="btn btn-success btn-sm" style="color: #FFFFFF;" href="{{ route('alterarStatus', array($unidade[0]->id, $doc->id, 3)) }}" > <i class="fa fa-times-circle"> </i></a>
                        @endif
                       </div>
                      </div>
                    </td>
                   </tr> 
                   @endforeach   
            </table>
                                
            <table>
             <tr><td> {{ $documentos->appends(['pesq' => isset($pesq) ? $pesq : ''])->render() }} </td></tr>
            </table>
        </div>
    </div>
</section >    
@endsection