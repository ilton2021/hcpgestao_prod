@extends('layouts.app2')
@section('title','Termo de Referência')
@section('content')
<head>
    <link href="{{ asset('css/rp_cards.css') }}" rel="stylesheet">
</head>
<body>
		<div class="container">
			<div class="row gy-3">
				<section class="cards">				
					<div class="card">
					  @if($und1 > 0) <div class="image"> @else <div class="image2"> @endif
					    <?php if($und1 > 0) { ?> <a href="{{ route('rp2', 1) }}"> <?php } ?>
						  <img title="{{$unidades[0]->sigla}}" src="{{asset('img')}}/{{$unidades[0]->path_img}}" alt="{{$unidades[0]->sigla}}">
						<?php if($und1 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und2 > 0) <div class="image"> @else <div class="image2"> @endif
					    <?php if($und2 > 0) { ?> <a href="{{ route('rp2', 2) }}"> <?php } ?>
						  <img title="{{$unidades[1]->sigla}}" src="{{asset('img')}}/{{$unidades[1]->path_img}}" alt="{{$unidades[1]->sigla}}">
					    <?php if($und2 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und3 > 0) <div class="image"> @else <div class="image2"> @endif
					  	<?php if($und3 > 0) { ?> <a href="{{ route('rp2', 3) }}"> <?php } ?>
						  <img title="{{$unidades[2]->sigla}}" src="{{asset('img')}}/{{$unidades[2]->path_img}}" alt="{{$unidades[2]->sigla}}">
						<?php if($und3 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und4 > 0) <div class="image"> @else <div class="image2"> @endif
					    <?php if($und4 > 0) { ?> <a href="{{ route('rp2', 4) }}"> <?php } ?>
						  <img title="{{$unidades[3]->sigla}}" src="{{asset('img')}}/{{$unidades[3]->path_img}}" alt="{{$unidades[3]->sigla}}">
						<?php if($und4 > 0) { ?> </a> <?php } ?>	
					  </div>
					</div>
				
					<div class="card">
					  @if($und5 > 0) <div class="image"> @else <div class="image2"> @endif
					    <?php if($und5 > 0) { ?> <a href="{{ route('rp2', 5) }}"> <?php } ?>
						  <img title="{{$unidades[4]->sigla}}" src="{{asset('img')}}/{{$unidades[4]->path_img}}" alt="{{$unidades[4]->sigla}}">
						<?php if($und5 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und6 > 0) <div class="image"> @else <div class="image2"> @endif
					    <?php if($und6 > 0) { ?> <a href="{{ route('rp2', 6) }}"> <?php } ?>
						  <img title="{{$unidades[5]->sigla}}" src="{{asset('img')}}/{{$unidades[5]->path_img}}" alt="{{$unidades[5]->sigla}}">
						<?php if($und6 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und7 > 0) <div class="image"> @else <div class="image2"> @endif
						<?php if($und7 > 0) { ?> <a href="{{ route('rp2', 7) }}"> <?php } ?>
						  <img title="{{$unidades[6]->sigla}}" src="{{asset('img')}}/{{$unidades[6]->path_img}}" alt="{{$unidades[6]->sigla}}">
						<?php if($und7 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und8 > 0) <div class="image"> @else <div class="image2"> @endif
					  	<?php if($und8 > 0) { ?> <a href="{{ route('rp2', 8) }}"> <?php } ?>
						  <img title="{{$unidades[7]->sigla}}" src="{{asset('img')}}/{{$unidades[7]->path_img}}" alt="{{$unidades[7]->sigla}}">
						<?php if($und8 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und9 > 0) <div class="image"> @else <div class="image2"> @endif
						<?php if($und9 > 0) { ?> <a href="{{ route('rp2', 9) }}"> <?php } ?>
						  <img title="{{$unidades[8]->sigla}}" src="{{asset('img')}}/{{$unidades[8]->path_img}}" alt="{{$unidades[8]->sigla}}">
						<?php if($und9 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>

					<div class="card">
					  @if($und10 > 0) <div class="image"> @else <div class="image2"> @endif
						<?php if($und10 > 0) { ?> <a href="{{ route('rp2', 10) }}"> <?php } ?>
						  <img title="{{$unidades[9]->sigla}}" src="{{asset('img')}}/{{$unidades[9]->path_img}}" alt="{{$unidades[9]->sigla}}">
						<?php if($und10 > 0) { ?> </a> <?php } ?>
					  </div>
					</div>
				</section>
			</div>
		</div>
</body>
@endsection