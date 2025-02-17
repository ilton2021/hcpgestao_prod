@extends('layouts.appCont')

@section('content')
<style>
    .modal {
        --bs-modal-width: 800px;
    }

    #cardContract{
        height: 300px;
        text-align: center;
    }

    #cardContract img{
        height: 300px;
    }

    a{
        text-decoration: none;
    }

    #divImgDoc{
        text-align: center;
    }

    #divImgDoc img{
        height: 300px;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex m-2">
                <div class="m-auto">
                <a href="{{ route('transparenciaContratos', $unidade[0]->id) }}" class="btn btn-warning">Voltar <i class="bi bi-reply"></i></a> &nbsp;&nbsp;&nbsp;
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#documents">
                        GERAR <i class="bi bi-newspaper"></i>
                    </button>
                    <div class="modal fade" id="documents" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">GERAR CONTRATO</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col border p-2">
                                        <a href="{{ route('gerarDistrato', 2) }}" target="_blank">
                                            <div class="card" id="cardContract">
                                                <img src="{{ asset('storage/contratosLayout/distrato.png') }}" alt="Distrato">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col border p-2">
                                        <a href="{{ route('gerarRenovacaoVig', 2) }}" target="_blank">
                                            <div class="card" id="cardContract">
                                                <img src="{{ asset('storage/contratosLayout/renovacao-vigencia.png') }}" alt="Renovação Vigência">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col border p-2">
                                        <a href="{{ route('gerarContConsExam', 2) }}" target="_blank">
                                            <div class="card justify-content-center" id="cardContract">
                                                <img src="{{ asset('storage/contratosLayout/contrato-de-consultas-exames-upae.png') }}" alt="Contrato de Consultas e Exames-Upae">
                                            </div>
                                        </a>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col border p-2">
                                        <a href="{{ route('contratoServMedCons', 2) }}" target="_blank">
                                            <div class="card justify-content-center" id="cardContract">
                                                <img src="{{ asset('storage/contratosLayout/contrato-servico-medico-consulta-upae.png') }}" alt="Contrato de Serviço Médico - Consulta (UPAE's)">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col border p-2">
                                        <a href="{{ route('gerarContServMedP', 2) }}" target="_blank">
                                            <div class="card justify-content-center" id="cardContract">
                                                <img src="{{ asset('storage/contratosLayout/contrato-servico-medico-plantao-upae.png') }}" alt="Contrato de Serviços Médico - Plantão (UPA)">
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col border p-2">
                                        <a href="{{ route('gerarContratoConsExamHmrArruda', 2) }}" target="_blank">
                                            <div class="card justify-content-center" id="cardContract">
                                                <img src="{{ asset('storage/contratosLayout/contrato-de-consultas-exames-upae.png') }}" alt="Contrato - Consultas e Exames - HMR e UPAE Arruda">
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-body-tertiary">
            <nav class="navbar bg-body-tertiary border-bottom">
                <div class="container-fluid">
                    <form class="d-flex" action="{{ route('documentosPesquisa', $unidade[0]->id) }}" role="search">
                        @csrf
                        <input class="form-control me-2" type="search" name="pesquisa" placeholder="Pesquisar" aria-label="Search">
                        <label for="" class="ms-4">Tipo:</label>
                        <select name="tipo_documento" id="tipo_documento" class="form form-select ms-2">
                            <option value=""></option>
                            <option value="1">Distratos</option>
                            <option value="2">Renovação Vigência</option>
                            <option value="3">Contrato Consultas e Exames (UPAE's)</option>
                            <option value="4">Contrato Serviço Médico - Consulta (UPAE's)</option>
                            <option value="5">Contrato Serviço Médico - Plantão (UPAE's)</option>
                            <option value="6">Contrato Consultas e Exames - HMR e UPAE ARRUDA</option>
                        </select>
                        <button class="btn btn-outline-success d-flex ms-3" type="submit">Pesquisar <i class="bi bi-search ms-2"></i></button>
                    </form>
                </div>
            </nav>

            <h5 class="mt-4 border-bottom" style="color: #595959;">Recentes</h5>

            <div class="row mb-4">
                @foreach($documentos as $documento)
                    <div class="col">
                        
                            <div class="card m-3" style="width: 300px">
                                <div id="divImgDoc">
                                    @if($documento->tipo_documento == 1)
                                        <img src="{{ asset('storage/contratosLayout/distrato.png') }}" alt="Distrato">
                                    @endif
                                    @if($documento->tipo_documento == 2)
                                        <img src="{{ asset('storage/contratosLayout/renovacao-vigencia.png') }}" alt="">
                                    @endif
                                    @if($documento->tipo_documento == 3)
                                        <img src="{{ asset('storage/contratosLayout/contrato-de-consultas-exames-upae.png') }}" alt="">
                                    @endif
                                    @if($documento->tipo_documento == 4)
                                        <img src="{{ asset('storage/contratosLayout/contrato-servico-medico-consulta-upae.png') }}" alt="">
                                    @endif
                                    @if($documento->tipo_documento == 5)
                                        <img src="{{ asset('storage/contratosLayout/contrato-servico-medico-plantao-upae.png') }}" alt="">
                                    @endif
                                    @if($documento->tipo_documento == 6)
                                        <img src="{{ asset('storage/contratosLayout/consultas-e-exames-hmr-e-upae-arruda.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="border-top p-3">
                                    <p><b>Documento:</b> {{ $documento->nome }}</p>
                                    <p><b>Criador:</b> {{ $documento->criador }}</p>
                                    <p><b>Data:</b> <?php $date=date_create($documento->data_criacao); echo date_format($date,"d/m/Y");?></p>
                                    @foreach($tiposDocumentos as $tipoDocumento)
                                        @if($tipoDocumento->id == $documento->tipo_documento)
                                            <p><b>Tipo:</b> {{ $tipoDocumento->nome }}</p>
                                        @endif
                                    @endforeach
                                    <div class="text-center"><a href="{{ asset($documento->caminho_arquivo) }}" class="btn btn-secondary btn-sm" target="_blank">Visualizar <i class="bi bi-box-arrow-up-right"></i></a></div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
