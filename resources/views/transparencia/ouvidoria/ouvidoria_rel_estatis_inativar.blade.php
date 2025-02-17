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
            <form class="text-center" action="{{ route('inativarOVRelatorioES', array($unidade->id, $relatoriosEs[0]->id)) }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-control mt-0" style="color:black">
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-3 mr-2">
                                <label><b>Arquivo:</b></label>
                            </div>
                            <div class="col-md-8 mr-2"> 
                                <input readonly class="form-control form-control-sm" type="text" id="arquivo" name="arquivo" value="<?php echo $relatoriosEs[0]->file_path; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-3 mr-2">
                                <label><b>Mês:</b></label>
                            </div>
                            <div class="col-md-8 mr-2"> 
                                <?php if($relatoriosEs[0]->mes == 1) { ?> <input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Janeiro" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 2) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Fevereiro" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 3) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Março" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 4) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Abril" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 5) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Maio" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 6) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Junho" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 7) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Julho" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 8) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Agosto" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 9) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Setembro" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 10) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Outubro" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 11) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Novembro" /> <?php } ?>
                                <?php if($relatoriosEs[0]->mes == 12) { ?><input readonly class="form-control form-control-sm" type="text" id="mes" name="mes" value="Dezembro" /> <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-3 mr-2">
                                <label><b>Ano:</b></label>
                            </div>
                            <div class="col-md-8 mr-2"> 
                                <input readonly class="form-control form-control-sm" type="text" id="ano" name="ano" value="<?php echo $relatoriosEs[0]->ano; ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-12 mr-2"> 
                                <a class="btn btn-warning btn-sm" style="color: white" href="{{route('cadastroOVRelatorioES', $unidade->id)}}"><i class="fas fa-reply"></i> <b>Voltar</b></a>
                                <input type="submit" class="btn btn-success btn-sm" value="Inativar" id="Salvar" name="Salvar" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="form-group col-md-12 d-inline-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="col-md-12 mr-2"> 
                                <input hidden type="text" id="unidade_id" name="unidade_id" value="<?php echo $unidade->id; ?>" />
                                <input hidden type="text" class="form-control" id="tela" name="tela" value="ouvidoriaRelEstastic" /> 
                                <input hidden type="text" class="form-control" id="acao" name="acao" value="inativarOuvidoriaRelEstastic" /> 
                                <input hidden type="text" class="form-control" id="user_id" name="user_id" value="{{ Auth::user()->id }}" /> 
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
        //var regex = /^[0-9.,]+$/;
        var regex = /^[0-9.]+$/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
</script>
@endsection