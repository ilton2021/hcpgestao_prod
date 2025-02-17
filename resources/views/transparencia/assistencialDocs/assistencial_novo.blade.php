@extends('navbar.default-navbar')
@section('content')
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif 
    <div class="row" style="margin-top: 25px; margin-left: auto; margin-right: auto; display: flex; justify-content: center">
		<div class="col-md-10 col-sm-4 text-center">
			<div class="accordion" id="accordionExample">
				<div class="card">
					<a class="card-header bg-success text-decoration-none text-white bg-success" type="button" data-toggle="collapse" data-target="#PESSOAL" aria-expanded="true" aria-controls="PESSOAL">
                        Relatório Anual de Gestão: <i class="fas fa-check-circle"></i>
					</a>
				</div>
			</div>
            <form method="POST" action="{{route('storeRADOC',$unidade->id)}}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-control mt-3" style="color:black">
                <div class="form-row mt-3">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-3 mr-1">
                            <label><b>Título:</b></label>
                        </div>
                        <div class="col-md-8 mr-4">
                            <select class="form-control form-control-sm" name="titulo" id="titulo" required>
                                <option value="">Escolha o Título</option>
                                <option value="Relatório Anual de Gestão">Relatório Anual de Gestão</option>
                                <option value="Relatório Anual de Gestão - COVID">Relatório Anual de Gestão - COVID</option>
                                <option value="Relatório Anual de Gestão - Maternidade">Relatório Anual de Gestão - Maternidade</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-3 mr-1">
                            <label><b>Ano:</b></label>
                        </div>
                        <div class="col-md-8 mr-4">
                        <?php $ano = date('Y', strtotime('now')); ?>
                            <select class="form-control form-control-sm" name="ano" id="ano" required>
                                <?php for ($i = 2020; $i <= $ano; $i++) { ?>
                                    <option value="{{$ano}}" <?php if($ano == $i) { echo 'selected'; } ?>>{{$i}}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-row mt-3">
                    <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                        <div class="col-md-3 mr-1">
                            <label><b>Arquivo:</b></label>
                        </div>
                        <div class="col-md-8 mr-4">
                            <input class="form-control form-control-sm" type="file" id="file_path" name="file_path" value="" required />
                        </div>
                    </div>
                </div>
                <div class="form-row mt-2">
						<div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
							<div class="col-md-12 mr-2">
							<center>
                                <a href="{{route('cadastroRA', $unidade->id)}}" class="btn btn-warning btn-sm" style="color:white;"><i class="fas fa-reply"></i> <b>Voltar</b></a>
								<input type="submit" value="Salvar" id="Salvar" name="Salvar" class="btn btn-success btn-sm" />
							</center>
							</div>
						</div>
					</div>
                </div>
            </form>
        </div>
    </div>
<script>
    var $input = document.getElementById('input-file'),
        $fileName = document.getElementById('file-name');
        $input.addEventListener('change', function() {
            $fileName.textContent = this.value;
        });
</script>
@endsection