@extends('layouts.app')
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP</title>
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
		<style>
        .navbar .dropdown-menu .form-control {
            width: 300px;
        }
        </style>
    </head>
@section('content')

<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div><div class="container-fluid">
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-12 text-center">
			<h3 style="font-size: 18px;"> CADASTRAR ÓRGÃO:</h3>
		</div>
	</div>
	@if ($errors->any())
			<div class="alert alert-success">
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
	@endif
	<div class="row" style="margin-top: 25px;">
		<div class="col-md-0 col-sm-0"></div>
		<div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                <a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                    Órgão <i class="fas fa-check-circle"></i>
                </a>
                </div>
				    <form method="post" action="{{route('storeORG', $unidade->id) }}">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<table class="table">
                	  <thead>
						<tr> 
							<td> Nome </td>
							<td> <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome') }}" required /> </td>
						</tr>
						<tr>
						<td colspan="6">
						 <a href="{{route('listarORG', $unidade->id)}}" id="Voltar" name="Voltar" type="button" class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> Voltar <i class="fas fa-undo-alt"></i> </a>
					     <input type="submit" class="btn btn-success btn-sm" style="margin-top: 10px;" value="Salvar" id="Salvar" name="Salvar" /> 
					    </td>
						</tr>
						</thead>
					</table>					
					<table>
						 <tr> 
						  	<td style="margin-left: 500px;"> <input hidden type="text" class="form-control" id="validar" name="validar" value="1"> </td>
                            <td> <input hidden style="width: 100px;" type="text" id="tela" name="tela" value="cadastro_orgao" /></td>
                            <td> <input hidden style="width: 100px;" type="text" id="acao" name="acao" value="cadastrar_orgao" /></td>
                            <td> <input hidden style="width: 100px;" type="text" id="user_id" name="user_id" value="<?php Auth::user()->id; ?>" /></td>
						 </tr>
					</table>	
                  </div>
            </div>
        </div>
    </div>
</div>
</section>    
@endsection