@extends('navbar.default-navbar')
@section('content') 
<div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>
    <div class="container-fluid" style="margin-top: 25px;">
        <div class="d-flex justify-content-center align-items-center">
            <h5 class="m-1" style="font-size: 18px;">SERVIÇO DE INFORMAÇÃO AO CLIENTE - SIC</h5>
        </div>
        @if ($errors->any())
        <div class="alert alert-danger text-center">
            <ul style="list-style: none;">
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
                            Relatório estastístico - PAI: <i class="fas fa-check-circle"></i>
                        </a>
                    </div>
                </div>
                <form class="text-center" action="{{\Request::route('storeOVRelatorioES'), $unidade->id}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-control mt-0" style="color:black">
                        <div class="form-row mt-3">
                            <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                                <div class="col-md-3 mr-2">
                                    <label><b>Arquivo:</b></label> 
                                </div>
                                <div class="col-md-8 mr-2">
                                    <input class="form-control form-control-sm" type="file" id="file_path" name="file_path" required />
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                                <div class="col-md-3 mr-2">
                                    <label><b>Mês</b></label>
                                </div>
                                <div class="col-md-8 mr-2">
                                    <select class="form-control form-control-sm" id="mes" name="mes" required>
                                        <option {{old('mes') == 1 ? "selected" : "" }} value="1">Janeiro</option>
                                        <option {{old('mes') == 2 ? "selected" : "" }} value="2">Fevereiro</option>
                                        <option {{old('mes') == 3 ? "selected" : "" }} value="3">Março</option>
                                        <option {{old('mes') == 4 ? "selected" : "" }} value="4">Abril</option>
                                        <option {{old('mes') == 5 ? "selected" : "" }} value="5">Maio</option>
                                        <option {{old('mes') == 6 ? "selected" : "" }} value="6">Junho</option>
                                        <option {{old('mes') == 7 ? "selected" : "" }} value="7">Julho</option>
                                        <option {{old('mes') == 8 ? "selected" : "" }} value="8">Agosto</option>
                                        <option {{old('mes') == 9 ? "selected" : "" }} value="9">Setembro</option>
                                        <option {{old('mes') == 10 ? "selected" : "" }} value="10">Outubro</option>
                                        <option {{old('mes') == 11 ? "selected" : "" }} value="11">Novembro</option>
                                        <option {{old('mes') == 12 ? "selected" : "" }} value="12">Dezembro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                                <div class="col-md-3 mr-2">
                                    <label><b>Ano</b></label>
                                </div>
                                <div class="col-md-8 mr-2">
                                    <select class="form-control form-control-sm" id="ano" name="ano" required> <?php $ano = date('Y', strtotime('now')); ?>
                                        <?php for($a = 2020; $a <= $ano; $a++) { ?>
                                            <option <?php if($a == $ano) { echo 'selected'; } ?> value="{{ $a }}">{{ $a }}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                                <div class="col-md-12 mr-2">
                                    <center>
                                        <a class="btn btn-warning btn-sm" style="color: white" href="{{route('cadastroOVRelatorioES', $unidade->id)}}"><i class="fas fa-reply"></i> <b>Voltar</b></a>
                                        <input type="submit" class="btn btn-success btn-sm" value="Salvar" id="Salvar" name="Salvar" />
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                                <div class="col-md-12 mr-2">
                                    <center>
                                        <input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
                                        <input hidden type="text" class="form-control" id="tela" name="tela" value="ouvidoriaRelEstastic" /> 
                                        <input hidden type="text" class="form-control" id="acao" name="acao" value="salvarOuvidoriaRelEstastic" /> 
                                        <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> 
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    function onlynumber(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /^[0-9.]+$/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
@endsection