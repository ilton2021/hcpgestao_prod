@extends('navbar.default-navbar')

@section('content')

<body>

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{$unidade->name}}</strong></div>

    <div class="row" style="margin-top: 25px;">
        <div class="col-md-12 col-sm-12 text-center">
            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingThree" style="background-color: #28a745!important;">
                        <h5 class="mb-0">
                            <a>
                                <strong style="color:azure;">Prorrogação de Contratação de Serviço: <i class="fas fa-check-circle" aria-hidden="true"></i></strong>
                            </a>
                        </h5>
                    </div>
                    @if ($sucesso == "ok")
                    <div class="alert alert-success" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @elseif($sucesso == "no")
                    <div class="alert alert-danger" style="font-size:20px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @foreach($contratacao_servicos as $CS)
                    <form method="POST" action="{{route('prorrContratacao',[$CS->id,$id_und])}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div style="margin-top:10px;margin-left:15px;margin-right:15px;" class="shadow p-3 mb-5 bg-white rounded">
                            <div class="input-group mb-3" style="display: flex;justify-content: center; text-align: center;">
                                <?php $disabled = "";
                                if ($CS->tipoPrazo == 0) {
                                    $disabled = "disabled";
                                } ?>
                                <label style="font-family:arial black;font-size:15px;margin-top:20px;">Data prazo prorrogação:</label>
                                <input style=" height: 40px;margin-top:15px;margin-left:20px" type="date" id="prazoProrroga" name="prazoProrroga" rows="4" cols="50" value="{{$CS->prazoProrroga}}" <?php echo $disabled; ?>></input>
                            </div>
                            @if($qtd > 0)
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6><b>Erratas</b></h6>
                                            </th>
                                            <th>
                                                <h6><b><center>Data de upload</center></b></h6>
                                            </th>
                                            <th>
                                                <h6><b><center>Arquivo</center></b></h6>
                                            </th>
                                            <th>
                                                <h6><b><center>Excluir</center></b></h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    @foreach($contratacao_erratas as $c_errata)
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input disabled  class="campo-dinamico" type="text" id="nome_arq_errata" name="nome_arq_errata" style="font-family:arial black;font-size:15px; width:400px;" value="<?php echo $c_errata->nome_arq_errata; ?>" title="<?php echo $c_errata->nome_arq_errata; ?>" />
                                            </td>
                                            <td>
                                              <center>
                                                <input disabled class="campo-dinamico" type="date" id="dtup_errata" name="dtup_errata" style="font-family:arial black;font-size:15px; width:200px;" value="<?php echo $c_errata->dtup_errata; ?>" title="<?php echo date('d/m/Y', strtotime($c_errata->dtup_errata)); ?>" />
                                              </center>
                                            </td>
                                            <td>
                                               <a id="div" class="btn btn-sm btn-primary" href="{{asset('storage')}}/{{$c_errata->arquivo_errata}}" target="_blank">Arquivo</a>
                                            </td>
                                            <td>
                                              <center>
                                                <a href="{{route('excluirErrataContratacao', array($CS->id, $c_errata->id, $id_und))}}" class="btn btn-danger" style="font-size:14px; margin-right:10px;font-family:arial"><i class="bi bi-trash3"></i></a>
                                              </center>
                                            </td>
                                        </tr>
                                    </tbody>
                                    @endforeach
                                </table>
                            </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h6><b>Nova Errata</b></h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr>
                                            <td><input class="campo-dinamico" type="file" id="nome_arq_errata" name="nome_arq_errata" style="font-family:arial black;font-size:15px;" /></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="input-group mb-4" style="display: flex;justify-content: center; text-align: center;">
                                <a href="{{route('paginaContratacaoServicos',$id_und)}}" class="btn btn-warning" style="font-size:17px; margin-right:10px;font-family:arial; color: white;"><strong>Voltar</strong><i class="fas fa-reply"></i></a>
                                <button type="submit" class="btn btn-success btn-sm" style="font-size:15px" value="salvar" id="salvar" name="salvar"><i class="bi bi-check-lg"><b>Salvar<b></i></button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </form>
    @endforeach

    <script language="JavaScript">
        //Marcar ou desmarcar todas a especialidades
        function toggle(source) {
            checkboxes = document.getElementsByClassName('especialidade');
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>

</body>

@endsection