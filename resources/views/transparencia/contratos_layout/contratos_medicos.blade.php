@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="text-center mt-2">CONTRATOS MÉDICOS:</h3>
                    <form action="{{ route('contratoMpdf', $documento[0]->id) }}" method="post">
                        @csrf
                        <div class="row m-3">
                            <div class="col-3"><label for="nome"><b>Nome do Contrato:</b></label></div>
                            <div class="col"><input type="text" class="form form-control" name="nomeDoc" id="nome" required></div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="unidades"><b>Unidades:</b></label>
                            </div>
                            <div class="col">
                                <select name="unidade" id="unidade" class="form form-selectform-control form-control-sm" required>
                                    <option value="<?php echo $unidade[0]->id; ?>"><?php echo $unidade[0]->sigla; ?></option>
                                </select>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('unidades') }}" class="btn btn-info"><i class="bi bi-plus"></i></a>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="nomeEmpresa"><b>Nome da Empresa:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="nomeEmpresa" id="nomeEmpresa" class="form form-control" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="cnpjEmpresa"><b>CNPJ da Empresa:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="cnpjEmpresa" id="cnpjEmpresa" class="form form-control" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="enderecoEmpresa"><b>Endereço da Empresa:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="enderecoEmpresa" id="enderecoEmpresa" class="form form-control" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="especialidadeMedica"><b>Especialidade Médica</b></label>
                            </div>
                            <div class="col">
                                <textarea name="especialidade" id="especialidade" class="form form-control" required></textarea>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="inicioContrato"><b>Data Início do Contrato:</b></label>
                            </div>
                            <div class="col">
                                <input type="date" name="inicioContrato" id="inicioContrato" class="form form-control" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="prazoVigencia"><b>Prazo Vigência:</b></label>
                            </div>
                            <div class="col">
                                <input type="date" name="prazoVigencia" id="prazoVigencia" class="form form-control" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="emailSolicitante"><b>E-mail do Solicitante:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="emailSolicitante" id="emailSolicitante" class="form form-control" required>
                            </div>
                        </div>
                        <div class="d-flex mt-2">
                            <div class="m-auto">
                                <a href="{{ route('homeContratosLayout', $unidade[0]->id) }}" class="btn btn-warning">Voltar <i class="bi bi-reply"></i></a>
                                <input type="submit" value="Gerar Contrato" class="btn btn-success">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection