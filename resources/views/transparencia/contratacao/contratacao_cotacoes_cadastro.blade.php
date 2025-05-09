@extends('navbar.default-navbar')
@section('content')
    <div class="container text-center" style="color: #28a745">Você está em: <strong>{{ $unidade->name }}</strong></div>
    <div class="container-fluid">
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 text-center">
                <h3 style="font-size: 18px;">CONTRATAÇÕES</h3>
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
        <a href="{{ route('transparenciaContratacao', [$unidade->id, 1]) }}" class="btn btn-warning btn-sm"
            style="color: #FFFFFF;"> <strong>Voltar </strong><i class="fas fa-reply"></i>
        </a>
        <div class="row" style="margin-top: 25px;">
            <div class="col-md-12 col-sm-12">
                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header text-center" id="headingTwo">
                            <h2 class="mb-0">
                                <a class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <strong>Cotações</strong>
                                </a>
                                <a class="btn btn-dark btn-sm" style="color: #FFFFFF;"
                                    href="{{ route('cotacoesNovo', $unidade->id) }}"> Novo <i class="fas fa-check"></i> </a>
                            </h2>
                        </div>
                        @if ($unidade->id !== 8)
                            <div class="card-body">
                                <div class="d-flex justify-content-center flex-wrap">
                                    <div class="d-flex justify-content-center m-1">
                                        <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1"
                                            role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample1">Processos
                                            de Compra</a>
                                    </div>
                                    <div class="d-flex justify-content-center m-1">
                                        <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample2"
                                            role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample2">Processos
                                            de contratação de terceiros</a>
                                    </div>

                                </div>
                                <div class="collapse border-0" id="multiCollapseExample1">
                                    <div class="card card-body border-0">
                                        <div class="container">
                                            <div class="text-center">
                                                <p>
                                                    <a class="btn btn-success" data-toggle="collapse"
                                                        href="#multiCollapseExample3" role="button" aria-expanded="false"
                                                        aria-controls="multiCollapseExample3">Síntese: Mapa do Sistema de
                                                        Síntese</a>
                                                    <a class="btn btn-success" data-toggle="collapse"
                                                        href="#multiCollapseExample4" role="button" aria-expanded="false"
                                                        aria-controls="multiCollapseExample4">Demais Processos</a>
                                                </p>
                                            </div>
                                            <div class="collapse border-0" id="multiCollapseExample3">
                                                <div class="card card-body border-0">
                                                    <div class="container">
                                                        @foreach ($cotacoes as $cotacaoFiles)
                                                            @if ($cotacaoFiles->proccess_name == 'MAPA DE COTAÇÕES')
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <th scope="col">Título</th>
                                                                        <th scope="col">Arquivo</th>
                                                                        <th scope="col">Excluir</th>
                                                                    </thead>
                                                                    <tbody>
                                                                        <th> {{ $cotacaoFiles->proccess_name }} </th>
                                                                        <th> <a target="_blank"
                                                                                href="{{ $cotacaoFiles->file_path }}"
                                                                                class="list-group-item list-group-item-action"
                                                                                style="font-size: 12px; padding: 0px; margin-left: 00px">{{ $cotacaoFiles->file_name }}
                                                                                <i style="color:#28a745"
                                                                                    class="fas fa-download"></i></a>
                                                                        </th>
                                                                        @if ($cotacaoFiles->status_cotacao == 0)
                                                                            <th>
                                                                                <a title="Ativar"
                                                                                    class="btn btn-success btn-sm"
                                                                                    style="color: #000000;"
                                                                                    href="{{ route('excluirCotacoes', [$unidade->id, $cotacaoFiles->id]) }}"><i class="bi bi-check-lg"></i></i></a>
                                                                            </th>
                                                                        @else
                                                                            <th>
                                                                                <a title="Inativar"
                                                                                    class="btn btn-warning btn-sm"
                                                                                    style="color: #000000;"
                                                                                    href="{{ route('excluirCotacoes', [$unidade->id, $cotacaoFiles->id]) }}"><i
                                                                                        class="fas fa-times-circle"></i></a>
                                                                            </th>
                                                                        @endif
                                                                    </tbody>
                                                                </table>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="collapse border-0" id="multiCollapseExample4">
                                                <div class="card card-body border-0">
                                                    <div class="container">
                                                        <table class="table table-sm">
                                                            <thead class="bg-success">
                                                                <tr>
                                                                    <th scope="col" style="width: 400px">Nº Solicitação
                                                                    </th>
                                                                    <th scope="col" style="width: 100px">Data da
                                                                        Solicitação</th>
                                                                    <th scope="col" style="width: 100px">Tipo de Pedido
                                                                    </th>
                                                                    <th scope="col" style="width: 100px">Qt. de Itens
                                                                        do
                                                                        Formulário</th>
                                                                    <th scope="col" style="width: 100px">Fornecedor
                                                                    </th>
                                                                    <th scope="col" style="width: 100px">CNPJ</th>
                                                                    <th scope="col" style="width: 100px">Nº O.C.</th>
                                                                    <th scope="col" style="width: 100px">Valor Total da
                                                                        O.C.</th>
                                                                    <th scope="col" style="width: 100px">Arquivos</th>
                                                                    <th scope="col" style="width: 100px">Download</th>
                                                                </tr>
                                                            </thead>
                                                            <?php $qtd = sizeof($processos); ?>
                                                            @if ($qtd > 0)
                                                                @foreach ($processos as $processo)
                                                                    <tbody>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ $processo->numeroSolicitacao }}
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            <?php if ($processo->dataSolicitacao == '1970-01-01') {
                                                                echo ""; ?> <?php } else { ?>
                                                                            {{ $processo->dataSolicitacao }}
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ $processo->tipoPedido }}
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ $processo->qtdItens }}
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ $processo->fornecedor }}
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ $processo->cnpj }}
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ $processo->numeroOC }}
                                                                        </td>
                                                                        <td class="text-truncate"
                                                                            style="max-width: 100px; font-size: 12px">
                                                                            {{ "R$ " . number_format($processo->totalValorOC, 2, ',', '.') }}
                                                                        </td>
                                                                        <td> <a class="btn btn-info btn-sm"
                                                                                style="color: #FFFFFF;"
                                                                                href="{{ route('arquivosCotacoes', [$unidade->id, $processo->id]) }}">
                                                                                <i class="fas fa-edit"></i></a> </td>
                                                                        <td>
                                                                            <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                                type="button" href="dropdownMenuButton"
                                                                                data-toggle="dropdown"
                                                                                aria-haspopup="true"
                                                                                aria-expanded="false">
                                                                                Visualizar
                                                                                <div id="div" class="dropdown-menu"
                                                                                    aria-labelledby="dropdownMenuButton"
                                                                                    style="font-size: 12px;">
                                                                                    @foreach ($processo_arquivos as $processoA)
                                                                                        @if ($processoA->processo_id == $processo->id)
                                                                                            <a id="div"
                                                                                                class="dropdown-item"
                                                                                                href="{{ asset('../public/storage/') }}/{{ $processoA->file_path }}"
                                                                                                target="_blank">Arquivo</a>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </div>
                                                                            </a>
                                                                        </td>
                                                                    </tbody>
                                                                @endforeach
                                                            @endif
                                                            <tr>
                                                                <td> {{ $processos->appends(['pesq' => isset($pesq) ? $pesq : ''])->render() }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="collapse border-0" id="multiCollapseExample2">
                                    <div class="d-flex justify-content-end mr-3">
                                        <a class="btn btn-dark btn-sm" style="color: #FFFFFF;"
                                            href="{{ route('ProcessContrataTerceirosCreate', $unidade->id) }}"> Novo <i
                                                class="fas fa-check"></i>
                                        </a>
                                    </div>
                                    <div class="card card-body border-0">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr align="center">
                                                        <th width="200px">Processo</th>
                                                        <th width="80px">Mês/Ano</th>
                                                        <th width="250px">Arquivos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $marcador = ''; ?>
                                                    @foreach ($cotacoes as $cotacao)
                                                        @if ($cotacao->proccess_name !== 'MAPA DE COTAÇÕES')
                                                            @if ($cotacao->proccess_name !== $marcador)
                                                                <tr>
                                                                    <td style="vertical-align: middle; font-size:14px">

                                                                        <strong>{{ $cotacao->proccess_name }}</strong>

                                                                    </td>
                                                                    <td align="center"
                                                                        style="vertical-align: middle; font-size:14px">
                                                                        <div class="d-flex flex-column">
                                                                            <strong><?php
                                                                            echo $cotacao->mes == 1 ? 'Janeiro' : ($cotacao->mes == 2 ? 'Fevereiro' : ($cotacao->mes == 3 ? 'Março' : ($cotacao->mes == 4 ? 'Abril' : ($cotacao->mes == 5 ? 'Maio' : ($cotacao->mes == 6 ? 'Junho' : ($cotacao->mes == 7 ? 'Julho' : ($cotacao->mes == 8 ? 'Agosto' : ($cotacao->mes == 9 ? 'Setembro' : ($cotacao->mes == 10 ? 'Outubro' : ($cotacao->mes == 11 ? 'Novembro' : ($cotacao->mes == 12 ? 'Dezembro' : '')))))))))));
                                                                            ?></strong>
                                                                            <strong>
                                                                                @if ($cotacao->ano !== 0)
                                                                                    {{ $cotacao->ano }}
                                                                                @endif
                                                                            </strong>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="d-flex flex-column">
                                                                            @foreach ($cotacoes as $cotacaoArqs)
                                                                                @if ($cotacao->proccess_name == $cotacaoArqs->proccess_name)
                                                                                    <div class="d-inline-flex m-1">
                                                                                        <a target="_blank"
                                                                                            href="<?php if (stripos($cotacaoArqs->file_path, 'http') === false) {
                                                                                                echo asset('storage/') . '/' . $cotacaoArqs->file_path;
                                                                                            } else {
                                                                                                echo $cotacaoArqs->file_path;
                                                                                            }
                                                                                            ?>"
                                                                                            class="list-group-item list-group-item-action"
                                                                                            style="font-size: 12px; padding: 0px; margin-left: 00px">
                                                                                            <?php if ($cotacaoArqs->id >= 168) {
                                                                                                echo substr($cotacaoArqs->file_name, 6, 300);
                                                                                            } else {
                                                                                                echo $cotacaoArqs->file_name;
                                                                                            } ?>

                                                                                            <i style="color:#28a745"
                                                                                                class="fas fa-download"></i>
                                                                                        </a>
                                                                                        @if ($cotacaoArqs->status_cotacao == 0)
                                                                                            <a title="Ativar"
                                                                                                class="btn btn-success btn-sm"
                                                                                                style="color: #000000;"
                                                                                                href="{{ route('excluirCotacoes', [$unidade->id, $cotacaoArqs->id]) }}"><i class="bi bi-check-lg"></i></a>
                                                                                        @else
                                                                                            <a title="Inativar"
                                                                                                class="btn btn-warning btn-sm"
                                                                                                style="color: #000000;"
                                                                                                href="{{ route('excluirCotacoes', [$unidade->id, $cotacaoArqs->id]) }}"><i
                                                                                                    class="fas fa-times-circle"></i></a>
                                                                                        @endif
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                            <?php $marcador = $cotacao->proccess_name; ?>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                @else
                    <div class="card-body text-center">
                        <p>
                            <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample1"
                                role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Processos de
                                Compra</a>
                            <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample2"
                                role="button" aria-expanded="false" aria-controls="multiCollapseExample2">Aquisições</a>
                        </p>
                        <div class="collapse border-0" id="multiCollapseExample1">
                            <div class="card card-body border-0">
                                <div class="container">
                                    <p>
                                        <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample4"
                                            role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample4">Mapa de Síntese</a>
                                        <a class="btn btn-success" data-toggle="collapse" href="#multiCollapseExample3"
                                            role="button" aria-expanded="false"
                                            aria-controls="multiCollapseExample3">Demais Processos</a>
                                    </p>

                                    <div class="collapse border-0" id="multiCollapseExample3">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                <p align="right"><a class="btn btn-dark btn-sm" style="color: #FFFFFF;"
                                                        href="{{ route('addCotacao', $unidade->id) }}"> Novo <i
                                                            class="fas fa-check"></i>
                                                    </a></p>
                                                <table class="table table-sm">
                                                    <thead class="bg-success">
                                                        <tr>
                                                            <th scope="col" style="width: 400px">Nº Solicitação</th>
                                                            <th scope="col" style="width: 100px">Data da Solicitação
                                                            </th>
                                                            <th scope="col" style="width: 100px">Tipo de Pedido</th>
                                                            <th scope="col" style="width: 100px">Qt. de Itens do
                                                                Formulário</th>
                                                            <th scope="col" style="width: 100px">Fornecedor</th>
                                                            <th scope="col" style="width: 100px">CNPJ</th>
                                                            <th scope="col" style="width: 100px">Nº O.C.</th>
                                                            <th scope="col" style="width: 100px">Valor Total da O.C.
                                                            </th>
                                                            <th scope="col" style="width: 100px">Arquivos</th>
                                                            <th scope="col" style="width: 100px">Download</th>
                                                        </tr>
                                                    </thead>
                                                    <?php $qtd = sizeof($processos); ?>
                                                    @if ($qtd > 0)
                                                        @foreach ($processos as $processo)
                                                            <tbody>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ $processo->numeroSolicitacao }}
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    <?php if ($processo->dataSolicitacao == '1970-01-01') {
                                                            echo ""; ?> <?php } else { ?>
                                                                    {{ $processo->dataSolicitacao }} <?php } ?>
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ $processo->tipoPedido }}
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ $processo->qtdItens }}
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ $processo->fornecedor }}
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ $processo->cnpj }}
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ $processo->numeroOC }}
                                                                </td>
                                                                <td class="text-truncate"
                                                                    style="max-width: 100px; font-size: 12px">
                                                                    {{ "R$ " . number_format($processo->totalValorOC, 2, ',', '.') }}
                                                                </td>
                                                                <td> <a class="btn btn-info btn-sm"
                                                                        style="color: #FFFFFF;"
                                                                        href="{{ route('arquivosCotacoes', [$unidade->id, $processo->id]) }}">
                                                                        <i class="fas fa-edit"></i></a> </td>
                                                                <td>
                                                                    <a class="badge badge-pill badge-primary dropdown-toggle"
                                                                        type="button" href="dropdownMenuButton"
                                                                        data-toggle="dropdown" aria-haspopup="true"
                                                                        aria-expanded="false">
                                                                        Visualizar
                                                                        <div id="div" class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton"
                                                                            style="font-size: 12px;">
                                                                            @foreach ($processo_arquivos as $processoA)
                                                                                @if ($processoA->processo_id == $processo->id)
                                                                                    <a id="div"
                                                                                        class="dropdown-item"
                                                                                        href="{{ asset('../public/storage/') }}/{{ $processoA->file_path }}"
                                                                                        target="_blank">Arquivo</a>
                                                                                @endif
                                                                            @endforeach
                                                                        </div>
                                                                    </a>
                                                                </td>
                                                            </tbody>
                                                        @endforeach
                                                    @endif
                                                    <tr>
                                                        <td> {{ $processos->appends(['pesq' => isset($pesq) ? $pesq : ''])->render() }}
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="collapse border-0" id="multiCollapseExample4">
                                        <div class="card card-body border-0">
                                            <div class="container">
                                                @foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
                                                    @if ($cotacao == 'MAPA DE COTAÇÕES')
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 400px">Título</th>
                                                                    <th scope="col" style="width: 200px">Download</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <th> <a style="font-size: 15px; color: #28a745"
                                                                        class="btn" data-toggle="collapse"
                                                                        role="button" aria-expanded="false">
                                                                        <strong>{{ $cotacao }}</strong>
                                                                    </a>
                                                                </th>
                                                                <th>
                                                                    @foreach ($cotacoes as $cotacaoFiles)
                                                                        @if ($cotacaoFiles->proccess_name == $cotacao)
                                                                            <a target="_blank"
                                                                                href="{{ $cotacaoFiles->file_path }}"
                                                                                class="list-group-item list-group-item-action"
                                                                                style="font-size: 12px; padding: 0px; margin-left: 00px">{{ $cotacaoFiles->file_name }}
                                                                                <i style="color:#28a745"
                                                                                    class="fas fa-download"></i></a>
                                                                        @endif
                                                                    @endforeach
                                                                </th>
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse border-0" id="multiCollapseExample2">
                            <div class="card card-body border-0">
                                <div class="container">
                                    @foreach ($cotacoes->pluck('proccess_name')->unique() as $key => $cotacao)
                                        @if ($cotacao !== 'MAPA DE COTAÇÕES')
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" style="width: 400px">Título</th>
                                                        <th scope="col" style="width: 200px">Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <th> <a style="font-size: 15px; color: #28a745" class="btn"
                                                            data-toggle="collapse" role="button" aria-expanded="false">
                                                            <strong>{{ $cotacao }}</strong>
                                                        </a>
                                                    </th>
                                                    <th>
                                                        @foreach ($cotacoes as $cotacaoFiles)
                                                            @if ($cotacaoFiles->proccess_name == $cotacao)
                                                                <a target="_blank"
                                                                    href="{{ asset('../storage') }}/{{ $cotacaoFiles->file_path }}"
                                                                    class="list-group-item list-group-item-action"
                                                                    style="font-size: 12px; padding: 0px; margin-left: 00px">{{ $cotacaoFiles->file_name }}
                                                                    <i style="color:#28a745"
                                                                        class="fas fa-download"></i></a>
                                                            @endif
                                                        @endforeach
                                                    </th>
                                                </tbody>
                                            </table>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
