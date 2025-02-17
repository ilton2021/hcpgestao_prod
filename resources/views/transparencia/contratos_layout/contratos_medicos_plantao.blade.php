@extends('layouts.app')

@section('content')
    <style>
        b{
            color: #595959;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h3 class="text-center mt-2" style="color: #595959;">Contrato Serviços Médico – Plantão (UPA):</h3>
                    <form action="{{ route('contratoServMedP', 2) }}" method="post">
                        @csrf
                        <div class="row m-3">
                            <div class="col-3"><label for="nome_contrato"><b>Nome do Contrato:</b></label></div>
                            <div class="col"><input type="text" class="form form-control form-control-sm" name="nome_contrato" id="nome_contrato" required></div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="unidades"><b>Unidades:</b></label>
                            </div>
                            <div class="col">
                                <select name="unidade_id" id="unidade_id" class="form form-select form-control form-control-sm" required>
                                    <option value="<?php echo $unidade[0]->id; ?>"><?php echo $unidade[0]->sigla; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="nome_empresa"><b>Nome da Empresa:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="nome_empresa" id="nome_empresa" class="form form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="cnpj_empresa"><b>CNPJ da Empresa:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="cnpj_empresa" id="cnpj_empresa" class="form form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="endereco_empresa"><b>Endereço da Empresa:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="endereco_empresa" id="endereco_empresa" class="form form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="especialidade_medica"><b>Especialidade Médica</b></label>
                            </div>
                            <div class="col">
                                <textarea name="especialidade_medica" id="especialidade_medica" class="form form-control form-control-sm" required></textarea>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="data_inicio_contrato"><b>Data Início do Contrato:</b></label>
                            </div>
                            <div class="col">
                                <input type="date" name="data_inicio_contrato" id="data_inicio_contrato" class="form form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="prazo_vigencia"><b>Prazo Vigência:</b></label>
                            </div>
                            <div class="col">
                                <input type="date" name="prazo_vigencia" id="prazo_vigencia" class="form form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col-3">
                                <label for="email"><b>E-mail do Solicitante:</b></label>
                            </div>
                            <div class="col">
                                <input type="text" name="email" id="email" class="form form-control form-control-sm" required>
                            </div>
                        </div>
                        <div class="d-flex mt-2 mb-3">
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

    <script>
        // Função para bloquear teclas e permitir apenas números
        function permitirApenasNumeros(event) {
            // Obtém o código da tecla pressionada
            const tecla = event.key;

            // Verifica se a tecla pressionada é um número
            if (!/^\d$/.test(tecla) && tecla !== "Backspace") {
                event.preventDefault(); // Bloqueia a tecla se não for um número
            }
        }

        // Seleciona o campo de input onde queremos aplicar o bloqueio
        const input = document.querySelector('#cnpjEmpresa');

        // Adiciona o evento 'keydown' ao input
        input.addEventListener('keydown', permitirApenasNumeros);

    </script>
    
    <script>
        const input2 = document.querySelector('#nomeDoc');

        input2.addEventListener('keydown', function(event) {
            if (event.key === ':' || event.key === '.') {
                event.preventDefault();
            }
        });
    </script>
@endsection