@extends('layouts.app')

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('img/favico.png')}}">
        <title>Portal da Transparencia - HCP Gest&atilde;o</title>
        <script src="https://kit.fontawesome.com/7656d93ed3.js" crossorigin="anonymous"></script>
        <link href="{{ asset('css/rp_cards.css') }}" rel="stylesheet">
    </head>

@section('content')
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
		</div>
    </div>
 <section id="unidades">
    <div class="container" style="margin-top:-35px; margin-bottom:20px;">
        <div class="row">
            <div class="col-12 text-center">
                <span><h4 style="color:#65b345; margin-bottom:0px;">CADASTRO DE DOCUMENTOS</h4></span>
            </div>
        </div>
    </div>

	<div class="container" style="margin-top:-25px;">
        <div class="row gy-3">
            <section class="cards">
            @foreach($unidades as $unidade)
                <div class="card">
                  <div class="image">
                    <a href="{{route('cadastroDocumentalLista', $unidade->id)}}"> 
                      <img title="{{$unidade->sigla}}" src="{{asset('img')}}/{{$unidade->path_img}}" alt="...">
                    </a>
                  </div>
                </div>
            @endforeach
            </section>  
        </div>
        <p align="right">
            <a class="btn btn-warning btn-sm m-2" href="{{route('index', $unidades[0]->id)}}" id="Voltar" name="Voltar" type="button" style="color: #FFFFFF;"> <i class="fas fa-reply"></i> <b>Voltar</b> </a>   
        </p> 
    </div>

    </section >    
@endsection
	