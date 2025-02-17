@extends('navbar.default-navbar')
@section('content')

    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 text-center">
                @if ($aditivos[0]->opcao == 0)
                    <h3 style="font-size: 18px;">EXCLUIR CONTRATO:</h3>
                @elseif($aditivos[0]->opcao == 1)
                    <h3 style="font-size: 18px;">EXCLUIR ADITIVO:</h3>
                @elseif($aditivos[0]->opcao == 3)
                    <h3 style="font-size: 18px;">EXCLUIR RERRATIFICAÇÃO:</h3>
                @else
                    <h3 style="font-size: 18px;">EXCLUIR DISTRATO:</h3>
                @endif
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 col-sm-12 text-center">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    @if ($aditivos[0]->opcao == 0)
                                        <strong>Contrato</strong>
                                    @elseif($aditivos[0]->opcao == 1)
                                        <strong>Aditivo</strong>
                                    @elseif($aditivos[0]->opcao == 3)
                                        <strong>Rerratificação</strong>
                                    @else
                                        <strong>Distrato</strong>
                                    @endif
                                </a>
                            </h2>
                        </div>
                        <form action="{{ \Request::route('destroyAditivo'), $unidade->id, $aditivos[0]->id }}"
                            method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <table border="0" class="table table-sm">
                                <tr>
                                    <td style="width: 300px"> <b>Prestador:</b> </td>
                                    <td> <input class="form-control form-control-sm" readonly type="text" id="prestador" name="prestador" value="<?php echo $prestadores[0]->id . ' / ' . $prestadores[0]->prestador; ?>">
                                </tr>
                                <tr>
                                    <td> <b>ID do 1º Contrato:</b> </td>
                                    <td> <input class="form-control form-control-sm" readonly type="text" id="id" name="id" value="<?php echo $contratos[0]->id; ?>" /> </td>
                                <tr>
                                    @if ($aditivos[0]->opcao == 0)
                                        <td><b>ID do contrato a excluir:</b></td>
                                    @elseif($aditivos[0]->opcao == 1)
                                        <td><b>ID do Aditivo a excluir:</b></td>
                                    @elseif($aditivos[0]->opcao == 3)
                                        <td><b>ID da Rerratificação a excluir:</b></td>
                                    @else
                                        <td><b>ID do Distrato a excluir:</b></td>
                                    @endif
                                    <td> <input readonly class="form-control form-control-sm" type="text" id="file_path" name="file_path" value="<?php echo $aditivos[0]->id; ?>" /> </td>
                                </tr>
                            </table>
                            <table border="0" class="table table-sm">
                                <tr>
                                    <td> <b>Título:</b> </td>
                                    <td colspan="3"> <input class="form-control form-control-sm" readonly type="text" id="objeto" name="objeto" value="<?php echo $contratos[0]->objeto; ?>" /> </td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <td> <b>Valor:</b> </td>
                                    <td> <input readonly class="form-control form-control-sm" type="number"
                                            id="valor" name="valor" value="<?php echo $aditivos[0]->valor; ?>" /> </td>
                                    <td> <b>Renovação Automática:</b> </td>
                                    <td>
                                        <select readonly name="renovacao_automatica" id="renovacao_automatica" class="form-control form-control-sm">
                                          <option value="<?php $aditivos[0]->renovacao_automatica; ?>"> <?php if ($aditivos[0]->renovacao_automatica === 1) { ?> SIM
                                            <?php } else { ?> NÃO <?php } ?> </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td> <b>Data Início:</b> </td>
                                    <td> <input readonly class="form-control form-control-sm" type="date" id="inicio" name="inicio" value="<?php echo $aditivos[0]->inicio; ?>" /> </td>
                                    <td> <b>Data Fim:</b> </td>
                                    <td> <input readonly class="form-control form-control-sm" type="date" id="fim" name="fim" value="<?php echo $aditivos[0]->fim; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> <b>Arquivo:</b> </td>
                                    <td colspan="3"> <input readonly class="form-control form-control-sm" type="text" id="file_path" name="file_path" title="{{ $contratos[0]->file_path }}" value="<?php echo $aditivos[0]->file_path; ?>" /> </td>
                                </tr>
                                <tr hidden>
                                    <td> Yellow Alert: </td>
                                    <td> <input class="form-control form-control-sm" readonly type="number" id="yellow_alert" name="yellow_alert" value="<?php echo $contratos[0]->yellow_alert; ?>" /> </td>
                                </tr>
                                <tr hidden>
                                    <td> Red Alert: </td>
                                    <td> <input class="form-control form-control-sm" readonly type="number" id="red_alert" name="red_alert" value="<?php echo $contratos[0]->red_alert; ?>" /> </td>
                                </tr>
                                <tr>
                                    <td> <input hidden style="width: 100px;" type="text" id="unidade_id"
                                            name="unidade_id" value="<?php echo $unidade->id; ?>" /></td>
                                    <td> <input hidden type="text" class="form-control" id="tela" name="tela"
                                            value="contratacao" /> </td>
                                    <td> <input hidden type="text" class="form-control" id="acao" name="acao"
                                            value="excluirContratacao" /> </td>
                                    <td> <input hidden type="text" class="form-control" id="user_id" name="user_id"
                                            value="{{ Auth::user()->id }}" /> </td>
                                </tr>
                            </table>
                            <div class="p-2 border border-secondary rounded">
                                <div class="d-flex justify-content-center">
                                    @if ($aditivos[0]->opcao == 0)
                                        <h6> Deseja realmente <strong style="color: red"> Excluir </strong>
                                            este <strong>Contrato</strong> ?? </h6>
                                        <?php $tipoArq = 'Contrato'; ?>
                                    @elseif($aditivos[0]->opcao == 1)
                                        <h6> Deseja realmente <strong style="color: red"> Excluir </strong>
                                            este <strong>Aditivo</strong> ?? </h6>
                                        <?php $tipoArq = 'Aditivo'; ?>
                                    @elseif($aditivos[0]->opcao == 3)
                                        <h6> Deseja realmente <strong style="color: red"> Excluir </strong>
                                            esta <strong>Rerratificação</strong> ?? </h6>
                                        <?php $tipoArq = 'Rerratificação'; ?>
                                    @else
                                        <h6> Deseja realmente <strong style="color: red"> Excluir </strong>
                                            este <strong>Distrato</strong> ?? </h6>
                                        <?php $tipoArq = 'Distrato'; ?>
                                    @endif
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="javascript:history.back();" id="Voltar" name="Voltar" type="button"
                                        class="btn btn-warning btn-sm" style="margin-top: 10px; color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i> </a>
                                    <input type="submit"
                                        class="btn btn-danger btn-sm"
                                        style="margin-top: 10px;" value="Excluir" id="statusMudanca"
                                        name="statusMudanca" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
