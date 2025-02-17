<?php

namespace App\Http\Controllers;

use App\Models\Ocorrencias;
use App\Models\OcorrenciasForm;
use App\Models\User;
use App\Models\Setor;
use App\Models\TiposOcorrencias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OcorrenciaController extends Controller
{
    public function index()
    {  
        if(Auth::user()->funcao == 2 || Auth::user()->funcao == 0) {
            $ocorrenciasForm = OcorrenciasForm::all();
            $ocorrencias = Ocorrencias::all();
            return view('ocorrencias.indexOcorrencia', compact('ocorrenciasForm', 'ocorrencias'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }
    public function show($id)
    {
        $ocorrenciasForm = OcorrenciasForm::where('id', $id)->get();
        $setor = Setor::all();
        $tiposOcorrencias = TiposOcorrencias::all();

        $tabela = "<div class='row '>";
        $return = "$tabela";
        $return .= "<div class='col-12 col-sm-6 p-2'>";
        $return .= "<label class='fw-bold mt-1' for='data_ocorrencia' class='form-label'>Data da Ocorrência:</label>";
        $return .= "<input class='form-control form-control-sm' type='date' name='data_ocorrencia' id='data_ocorrencia' aria-label='.form-control-sm' value='" . $ocorrenciasForm[0]->data_ocorrencia . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' for='data_relato' class='form-label'>Data do relato:</label>";
        $return .= "<input class='form-control form-control-sm' type='date' name='data_relato' id='data_relato' aria-label='.form-control-sm' value'" . $ocorrenciasForm[0]->data_relato . "' readonly>";
        $return .= "<label class='fw-bold mt-1' for='processo' class='form-label'>Processo:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->processo . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' for='origem' class='form-label'>Origem:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->origem . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' for='unidade' class='form-label'>Unidade:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->unidade . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' for='unidade' class='form-label'>Esta notificação é ?</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->notificacao . "' readonly/>";
        $return .= "</div>";
        $return .= "<div class='col-12 col-sm-6  p-2'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Nome do paciente:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->nome_paciente . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Registro:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->registro . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Data de nascimento:</label>";
        $return .= "<input class='form-control form-control-sm' type='date' value='" . $ocorrenciasForm[0]->data_nascimento . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Tipo:</label>";
        $return .= "<input class='form-control form-control-sm' value='" .
            ($ocorrenciasForm[0]->tipoocorrencia == 1 ? 'Real (Já ocorrida)' : ($ocorrenciasForm[0]->tipoocorrencia == 2 ? 'Potencial (pode ocorrer)' : 'Oportunidade de melhoria')) .   "' readonly/>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Ocorrência:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->ocorrencia . "' readonly/>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Descrição da ocorrência:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->descricao_ocorrencia . "' readonly/>";
        $return .= "</div>";
        $return .= "</div>";
        $return .= "<hr>";
        $return .= "<div class='row '>";
        $return .= "<div class='col-12 col-sm-6 p-3'>";
        $return .= "<label class='fw-bold mt-1' for='nome_paciente' class='form-label'>Descrição do evento</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->descricao_evento . "' readonly/>";
        $return .= "</div>";
        $return .= "<div class='col-12 col-sm-6 p-3'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Ação corretiva</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->acao_imediata . "' readonly/>";
        $return .= "<div class='d-sm-flex justify-content-between'>";
        $return .= "<div class='d-flex flex-column'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Data</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->data_acao_corretiva . "' readonly/>";
        $return .= "</div>";
        $return .= "<div class='d-flex flex-column'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Responsável pela Ação:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->responsavel_acao . "' readonly/>";
        $return .= "</div>";
        $return .= "</div>";
        $return .= "</div>";
        $return .= "</div>";
        $return .= "<hr>";
        $return .= "<div class='row'>";
        $return .= "<div class='col-12 col-sm-4 p-3'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Classificação da ocorrência:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->classificacao_ocorrencia . "' readonly/>";
        $return .= "</div>";
        $return .= "<div class='col-12 col-sm-4 p-3'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Classificação do Dano:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->classificacao_dano . "' readonly/>";
        $return .= "</div>";
        $return .= "<div class='col-12 col-sm-4 p-3'>";
        $return .= "<label class='fw-bold mt-1' class='form-label'>Classificar o Tipo de Incidente:</label>";
        $return .= "<input class='form-control form-control-sm' value='" . $ocorrenciasForm[0]->classificar_incidente . "' readonly/>";
        $return .= "</div>";

        $return .= "</div>";
        $return .= "<hr>";

        echo $return;
    }
}