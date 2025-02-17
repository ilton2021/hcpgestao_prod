<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\ContratosLayout;
use App\Models\DistratosLayout;
use App\Models\RenovacaoVigencia;
use App\Models\ContratoConsultasExames;
use App\Models\ContratoServicoMedico;
use App\Models\ContratoServicoMedicoPlantao;
use App\Models\ContratoConsultasExamesHmrArruda;
use App\Models\TipoDocumento;
use PhpOffice\PhpWord\TemplateProcessor;
use Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Auth;
use DB;

class ContratosLayoutController extends Controller
{
    // Pesquisa Por Documentos
    public function documentosPesquisa($id, Request $request)
    {
        $input = $request->all();

        if($input['tipo_documento'] != ''){
            $documentos = ContratosLayout::where('tipo_documento', $input['tipo_documento'])->orderBy('created_at', 'DESC')->get();
        }

        if($input['pesquisa'] != ''){
            $documentos = ContratosLayout::where('nome', 'like', $input['pesquisa'].'%')->orderBy('created_at', 'DESC')->get();
        }

        if($input['pesquisa'] != '' && $input['tipo_documento'] != ''){
            $documentos = ContratosLayout::where('nome', 'like', $input['pesquisa'].'%')->where('tipo_documento', $input['tipo_documento'])->orderBy('created_at', 'DESC')->get();
        }

        if($input['pesquisa'] == '' && $input['tipo_documento'] == ''){
            $documentos = ContratosLayout::where('nome', 'like', $input['pesquisa'].'%')->orderBy('created_at', 'DESC')->get();
        }
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        $tiposDocumentos = TipoDocumento::all();
        return view('transparencia.contratos_layout.home_layout', compact('documentos', 'tiposDocumentos', 'unidades', 'unidade'));
    }

    // Gerar Distrato
    public function gerarDistrato($id)
    {
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.distratos', compact('unidades', 'unidade'));
    }

    public function distratoPdf($id, Request $request)
	{
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'nome_distrato'        => 'required|max:255',
            'unidade_id'           => 'required|max:255',
            'nome_empresa'         => 'required|max:255',
            'cnpj_empresa'         => 'required|max:255',
            'endereco_empresa'     => 'required|max:255',
            'resumo'               => 'required|max:255',
            'data_inicio_contrato' => 'required|date',
            'data_inicio_distrato' => 'required|date',
            'data_assinatura'      => 'required|date',
            'email'                => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            try {
                
                $unidades = Unidade::all();
                $unidade  = Unidade::where('id', $input['unidade_id'])->get();
                $nomeDocumento    = $input['nome_distrato'];
                $unidadeSobGestao = $unidade[0]->nome;
                $nomeEmpresa      = $input['nome_empresa'];
                $cnpjEmp          = $input['cnpj_empresa'];
                $idUnd            = $unidade[0]->id;
                function mask($val, $mask)
                {
                    $dataMaskared = '';
                    $p = 0;
                    for ($a = 0; $a <= strlen($mask) - 1; ++$a) {
                        if ($mask[$a] == '#') {
                            if (isset($val[$p])) {
                                $dataMaskared .= $val[$p++];
                            }
                        } else {
                            if (isset($mask[$a])) {
                                $dataMaskared .= $mask[$a];
                            }
                        }
                    }
                    return $dataMaskared;
                }
                $cnpjEmpresa     = mask($cnpjEmp, '##.###.###/####-##');
                $enderecoUnidade = $unidade[0]->endereco;
                $cnpjUnidade     = $unidade[0]->cnpj;
                $enderecoEmpresa = $input['endereco_empresa'];
                $resumo          = $input['resumo'];
                $data_contrato   = $input['data_inicio_contrato'];
                $data_distrato   = $input['data_inicio_distrato'];
                $pdf = \PDF::loadView('pdf.distratos', compact('input','unidade','unidadeSobGestao','nomeEmpresa','cnpjUnidade','enderecoUnidade','enderecoEmpresa', 'cnpjEmpresa','resumo','data_contrato','data_distrato'))->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
                $pdf->setPaper('A4', 'portrait');
                $pdf->save('../public/storage/contratos_gerados/'.$nomeDocumento.'.pdf');

                // Salvando Contrato
                $input['nome'] = $nomeDocumento;
                $input['criador'] = Auth::user()->name;
                $input['tipo_documento'] = 1;
                $input['data_criacao'] = date('Y-m-d', strtotime('now'));
                $input['arquivo'] = $nomeDocumento.'.pdf';
                $input['caminho_arquivo'] = 'storage/contratos_gerados/'.$nomeDocumento.'.pdf';
                $input['unidade_id'] = $id;
                $documentos = ContratosLayout::create($input);
                $idDoc      = DB::table('contratos_layout')->max('id');
                $input['contrato_id'] = $idDoc;
                $distrato   = DistratosLayout::create($input);
                return $pdf->stream($nomeDocumento.'.pdf');
            } catch(Throwable $e) {
                return redirect()->back()
                    ->withErrors($e)
                    ->withInput(session()->flashInput($request->input()));
            }
        }   
	}

    // Gerar Renovação de Vigência
    public function gerarRenovacaoVig($id)
    {
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.renovacao_vigencia', compact('unidades', 'unidade'));
    }

    public function renovacaoVig($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'nome_vigencia'        => 'required|max:255',
            'numero_aditivo'       => 'required|max:255',
            'unidade_id'           => 'required|max:255',
            'nome_empresa'         => 'required|max:255',
            'cnpj_empresa'         => 'required|max:14',
            'endereco_empresa'     => 'required|max:255',
            'prazo_vigencia'       => 'required|date',
            'data_inicio_contrato' => 'required|date',
            'data_fim_contrato'    => 'required|date',
            'data_assinatura'      => 'required|date',
            'email'                => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            try {
                $unidades = Unidade::all();
                $unidade  = Unidade::where('id', $id)->get();
                $nomeDocumento    = $input['nome_vigencia'];
                $unidadeSobGestao = $unidade[0]->nome;
                $unidadeEndereco  = $unidade[0]->endereco;
                $cnpjUnidade      = $unidade[0]->cnpj;
                $numeracaoAditivo = $input['numero_aditivo'];
                $nomeEmpresa      = $input['nome_empresa'];
                $cnpjEmp          = $input['cnpj_empresa'];
                function mask($val, $mask)
                {
                    $dataMaskared = '';
                    $p = 0;
                    for ($a = 0; $a <= strlen($mask) - 1; ++$a) {
                        if ($mask[$a] == '#') {
                            if (isset($val[$p])) {
                                $dataMaskared .= $val[$p++];
                            }
                        } else {
                            if (isset($mask[$a])) {
                                $dataMaskared .= $mask[$a];
                            }
                        }
                    }
                    return $dataMaskared;
                }
                $cnpjEmpresa         = mask($cnpjEmp, '##.###.###/####-##');
                $enderecoEmpresa     = $input['endereco_empresa'];
                $prazoVigencia       = $input['prazo_vigencia'];
                $dataInicioContrato  = $input['data_inicio_contrato'];
                $dataTerminoContrato = $input['data_fim_contrato'];
                $dataAssinatura      = $input['data_assinatura'];
                $pdf = \PDF::loadView('pdf.renovacao_vigencia', compact('input','unidade','unidadeSobGestao', 'numeracaoAditivo', 'nomeEmpresa','cnpjUnidade','unidadeEndereco','enderecoEmpresa', 'cnpjEmpresa','prazoVigencia','dataInicioContrato', 'dataTerminoContrato', 'dataAssinatura'))->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);;
                $pdf->setPaper('A4', 'landscape');
                $pdf->save('../public/storage/contratos_gerados/'.$nomeDocumento.'.pdf');

                // Salvando Contrato
                $input['nome'] = $nomeDocumento;
                $input['criador'] = Auth::user()->name;
                $input['tipo_documento'] = 2;
                $input['data_criacao'] = date('Y-m-d', strtotime('now'));
                $input['arquivo'] = $nomeDocumento.'.pdf';
                $input['caminho_arquivo'] = 'storage/contratos_gerados/'.$nomeDocumento.'.pdf';
                $input['unidade_id'] = $id;
                $documentos = ContratosLayout::create($input);
                $idDoc      = DB::table('contratos_layout')->max('id');
                $input['contrato_id'] = $idDoc;
                $prazoV     = RenovacaoVigencia::create($input);
                return $pdf->stream($nomeDocumento.'.pdf');
            } catch(Throwable $e) {
                return redirect()->back()
                    ->withErrors($e)
                    ->withInput(session()->flashInput($request->input()));
            }
        }
    }

    // Gerar Contrato de Consultas e Exames
    public function gerarContConsExam($id)
    {
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.contratos_consultas_exames', compact('unidades', 'unidade'));
    }

    public function contratoConsultasMed($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'nome_contrato'           => 'required',
            'unidade_id'              => 'required',
            'nome_empresa'            => 'required',
            'cnpj_empresa'            => 'required',
            'endereco_empresa'        => 'required',
            'especialidade_medica'    => 'required',
            'numero_consultas'        => 'required',
            'numero_exames'           => 'required',
            'nome_exame'              => 'required',
            'valor_unitario_consulta' => 'required',
            'valor_unitario_exame'    => 'required',
            'prazo_vigencia'          => 'required',
            'data_inicio_contrato'    => 'required',
            'data_fim_contrato'       => 'required',
            'data_assinatura'         => 'required',
            'email'                   => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            try {
                $unidades = Unidade::all();	
                $unidade  = Unidade::where('id', $id)->get();
                $nomeDocumento    = $input['nome_contrato'];
                $unidadeSobGestao = $unidade[0]->nome;
                $unidadeEndereco  = $unidade[0]->endereco;
                $cnpjUnidade      = $unidade[0]->cnpj;
                $nomeEmpresa      = $input['nome_empresa'];
                $cnpjEmp          = $input['cnpj_empresa'];
                function mask($val, $mask)
                {
                    $dataMaskared = '';
                    $p = 0;
                    for ($a = 0; $a <= strlen($mask) - 1; ++$a) {
                        if ($mask[$a] == '#') {
                            if (isset($val[$p])) {
                                $dataMaskared .= $val[$p++];
                            }
                        } else {
                            if (isset($mask[$a])) {
                                $dataMaskared .= $mask[$a];
                            }
                        }
                    }
                    return $dataMaskared;
                }
                $cnpjEmpresa      = mask($cnpjEmp, '##.###.###/####-##');
                $enderecoEmpresa  = $input['endereco_empresa'];
                $especialidade    = $input['especialidade_medica'];
                $numConsultasMes  = $input['numero_consultas'];
                $numExamesMes     = $input['numero_exames'];
                $nomeExame        = $input['nome_exame'];
                $valorUniCons     = $input['valor_unitario_consulta'];
                $valorUniExam     = $input['valor_unitario_exame'];
                $prazoVigencia    = $input['prazo_vigencia'];
                $inicioContrato   = $input['data_inicio_contrato'];
                $terminoContrato  = $input['data_fim_contrato'];
                $dataAssinatura   = $input['data_assinatura'];
                $emailSolicitante = $input['email'];
                $pdf = \PDF::loadView('pdf.contratos_consultas_exames', compact('input','unidade','unidadeSobGestao','nomeEmpresa','cnpjUnidade','unidadeEndereco','enderecoEmpresa', 'cnpjEmpresa','especialidade', 'numConsultasMes', 'numExamesMes', 'nomeExame', 'valorUniCons', 'valorUniExam', 'prazoVigencia', 'inicioContrato', 'terminoContrato', 'dataAssinatura', 'emailSolicitante'))->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
                $pdf->setPaper('A4', 'landscape');
                $pdf->save('../public/storage/contratos_gerados/'.$nomeDocumento.'.pdf');

                // Salvando Contrato
                $input['nome'] = $nomeDocumento;
                $input['criador'] = Auth::user()->name;
                $input['tipo_documento'] = 3;
                $input['data_criacao'] = date('Y-m-d', strtotime('now'));
                $input['arquivo'] = $nomeDocumento.'.pdf';
                $input['caminho_arquivo'] = 'storage/contratos_gerados/'.$nomeDocumento.'.pdf';
                $input['unidade_id'] = $id;
                $documentos = ContratosLayout::create($input);
                $idDoc      = DB::table('contratos_layout')->max('id');
                $input['contrato_id'] = $idDoc;
                $contratoCE = ContratoConsultasExames::create($input);
                return $pdf->stream($nomeDocumento.'.pdf');
            } catch(Throwable $e) {
                return redirect()->back()
                    ->withErrors($e)
                    ->withInput(session()->flashInput($request->input()));
            }
        }
    }

    // Contrato de Serviço Médico – Consultas
    public function gerarContratoServMedCons($id)
    {
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.contrato_servicos_medicos_consulta', compact('unidades', 'unidade'));
    }

    public function contratoServMedCons($id, Request $request)
    {
        $input = $request->all();
        $validator = validator::make($request->all(), [
            'nome_contrato'            => 'required|max:255',
            'unidade_id'               => 'required|max:255',
            'nome_empresa'             => 'required|max:255',
            'cnpj_empresa'             => 'required|max:255',
            'endereco_empresa'         => 'required|max:255',
            'especialidade_medica'     => 'required|max:255',
            'numero_consultas_mensais' => 'required|max:255',
            'nome_exame'               => 'required|max:255',
            'valor_unitario_consulta'  => 'required|max:255',
            'prazo_vigencia'           => 'required|date',
            'data_inicio_contrato'     => 'required|date',
            'data_fim_contrato'        => 'required|date',
            'data_assinatura'          => 'required|date',
            'email'                    => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            try {
                $unidades = Unidade::all();	
                $unidade  = Unidade::where('id', $id)->get();
                $nomeDocumento    = $input['nome_contrato'];
                $unidadeSobGestao = $unidade[0]->nome;
                $unidadeEndereco  = $unidade[0]->endereco;
                $cnpjUnidade      = $unidade[0]->cnpj;
                $nomeEmpresa      = $input['nome_empresa'];
                $cnpjEmp          = $input['cnpj_empresa'];
                function mask($val, $mask)
                {
                    $dataMaskared = '';
                    $p = 0;
                    for ($a = 0; $a <= strlen($mask) - 1; ++$a) {
                        if ($mask[$a] == '#') {
                            if (isset($val[$p])) {
                                $dataMaskared .= $val[$p++];
                            }
                        } else {
                            if (isset($mask[$a])) {
                                $dataMaskared .= $mask[$a];
                            }
                        }
                    }
                    return $dataMaskared;
                }
                $cnpjEmpresa      = mask($cnpjEmp, '##.###.###/####-##');
                $enderecoEmpresa  = $input['endereco_empresa'];
                $especialidade    = $input['especialidade_medica'];
                $numConsultasMes  = $input['numero_consultas_mensais'];
                $nomeExame        = $input['nome_exame'];
                $valorUniCons     = $input['valor_unitario_consulta'];
                $prazoVigencia    = $input['prazo_vigencia'];
                $inicioContrato   = $input['data_inicio_contrato'];
                $terminoContrato  = $input['data_fim_contrato'];
                $dataAssinatura   = $input['data_assinatura'];
                $emailSolicitante = $input['email'];
                $pdf = \PDF::loadView('pdf.contrato_servico_medico_consultas', compact('input','unidade','unidadeSobGestao','nomeEmpresa','cnpjUnidade','unidadeEndereco','enderecoEmpresa', 'cnpjEmpresa','especialidade', 'numConsultasMes', 'nomeExame', 'valorUniCons', 'prazoVigencia', 'inicioContrato', 'terminoContrato', 'dataAssinatura', 'emailSolicitante'))->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);;
                $pdf->setPaper('A4', 'landscape');
                $pdf->save('../public/storage/contratos_gerados/'.$nomeDocumento.'.pdf');

                // Salvando Contrato
                $input['nome'] = $nomeDocumento;
                $input['criador'] = Auth::user()->name;
                $input['tipo_documento'] = 4;
                $input['data_criacao'] = date('Y-m-d', strtotime('now'));
                $input['arquivo'] = $nomeDocumento.'.pdf';
                $input['caminho_arquivo'] = 'storage/contratos_gerados/'.$nomeDocumento.'.pdf';
                $input['unidade_id'] = $id;
                $documentos = ContratosLayout::create($input);
                $idDoc      = DB::table('contratos_layout')->max('id');
                $input['contrato_id'] = $idDoc;
                $contratoSM = ContratoServicoMedico::create($input);
                return $pdf->stream($nomeDocumento.'.pdf');
            } catch(Throwable $e) {
                return redirect()->back()
                    ->withErrors($e)
                    ->withInput(session()->flashInput($request->input()));
            }
        }
    }

    // Gerar Contratos de Serviços Médicos (Plantão)
    public function gerarContServMedP($id)
    {
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.contratos_medicos_plantao', compact('unidades', 'unidade'));
    }

	public function contratoServMedP($id, Request $request)
	{
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'nome_contrato'        => 'required|max:255',
            'unidade_id'           => 'required|max:255',
            'nome_empresa'         => 'required|max:255',
            'cnpj_empresa'         => 'required|max:255',
            'endereco_empresa'     => 'required|max:255',
            'prazo_vigencia'       => 'required|date',
            'data_inicio_contrato' => 'required|date',
            'especialidade_medica' => 'required|max:255',
            'email'                => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            try {
                $unidades = Unidade::all();	
                $unidade = Unidade::where('id', $id)->get();
                $nomeDocumento    = $input['nome_contrato'];
                $unidadeSobGestao = $unidade[0]->nome;
                $unidadeEndereco  = $unidade[0]->endereco;
                $cnpjUnidade      = $unidade[0]->cnpj;
                $nomeEmpresa      = $input['nome_empresa'];
                $cnpjEmp          = $input['cnpj_empresa'];
                function mask($val, $mask)
                {
                    $dataMaskared = '';
                    $p = 0;
                    for ($a = 0; $a <= strlen($mask) - 1; ++$a) {
                        if ($mask[$a] == '#') {
                            if (isset($val[$p])) {
                                $dataMaskared .= $val[$p++];
                            }
                        } else {
                            if (isset($mask[$a])) {
                                $dataMaskared .= $mask[$a];
                            }
                        }
                    }
                    return $dataMaskared;
                }
                $cnpjEmpresa     = mask($cnpjEmp, '##.###.###/####-##');
                $enderecoEmpresa = $input['endereco_empresa'];
                $prazoVigencia   = $input['prazo_vigencia'];
                $inicioContrato  = $input['data_inicio_contrato'];
                $especialidade   = $input['especialidade_medica'];
                $pdf = \PDF::loadView('pdf.contratos_medicos_plantao', compact('input','unidade','unidadeSobGestao','nomeEmpresa','cnpjUnidade','unidadeEndereco','enderecoEmpresa', 'cnpjEmpresa','prazoVigencia','inicioContrato','especialidade'))->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);;
                $pdf->setPaper('A4', 'landscape');
                $pdf->save('../public/storage/contratos_gerados/'.$nomeDocumento.'.pdf');

                // Salvando Contrato
                $input['nome'] = $nomeDocumento;
                $input['criador'] = Auth::user()->name;
                $input['tipo_documento'] = 5;
                $input['data_criacao'] = date('Y-m-d', strtotime('now'));
                $input['arquivo'] = $nomeDocumento.'.pdf';
                $input['caminho_arquivo'] = 'storage/contratos_gerados/'.$nomeDocumento.'.pdf';
                $input['unidade_id'] = $id;
                $documentos = ContratosLayout::create($input);
                $idDoc      = DB::table('contratos_layout')->max('id');
                $input['contrato_id'] = $idDoc;
                $contratoSM = ContratoServicoMedicoPlantao::create($input);
                return $pdf->stream($nomeDocumento.'.pdf');
            } catch(Throwable $e) {
                return redirect()->back()
                    ->withErrors($e)
                    ->withInput(session()->flashInput($request->input()));
            }
        }  
	}

    // Gerar Contratos – Consultas e Exames – HMR e UPAE Arruda
    public function gerarContratoConsExamHmrArruda($id)
    {
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.contratos_consultas_exames_hmr_arruda', compact('unidades', 'unidade'));
    }

    public function contratoConsExamHmrArruda($id, Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'nome_contrato'        => 'required|max:255',
            'unidade_id'           => 'required|max:255',
            'nome_empresa'         => 'required|max:255',
            'cnpj_empresa'         => 'required|max:255',
            'endereco_empresa'     => 'required|max:255',
            'especialidade_medica' => 'required|max:255',
            'numero_consultas'     => 'required|max:255',
            'valor_consulta'       => 'required|max:255',
            'prazo_vigencia'       => 'required|date',
            'data_inicio_contrato' => 'required|date',
            'gestor_contrato'      => 'required|max:255',
            'data_assinatura'      => 'required|date',
            'email'                => 'required|max:255'
        ]);
        if($validator->fails()){
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            try {
                $unidades = Unidade::all();	
                $unidade  = Unidade::where('id', $id)->get();
                $nomeDocumento    = $input['nome_contrato'];
                $unidadeSobGestao = $unidade[0]->nome;
                $enderecoUnidade  = $unidade[0]->endereco;
                $nomeEmpresa      = $input['nome_empresa'];
                $cnpjUnidade      = $unidade[0]->cnpj;
                $cnpjEmp          = $input['cnpj_empresa'];
                function mask($val, $mask)
                {
                    $dataMaskared = '';
                    $p = 0;
                    for ($a = 0; $a <= strlen($mask) - 1; ++$a) {
                        if ($mask[$a] == '#') {
                            if (isset($val[$p])) {
                                $dataMaskared .= $val[$p++];
                            }
                        } else {
                            if (isset($mask[$a])) {
                                $dataMaskared .= $mask[$a];
                            }
                        }
                    }
                    return $dataMaskared;
                }
                $cnpjEmpresa      = mask($cnpjEmp, '##.###.###/####-##');
                $enderecoEmpresa  = $input['endereco_empresa'];
                $especialidade    = $input['especialidade_medica'];
                $numConsultas     = $input['numero_consultas'];
                $valorConsulta    = $input['valor_consulta'];
                $prazoVigencia    = $input['prazo_vigencia'];
                $inicioContrato   = $input['data_inicio_contrato'];
                $gestorContrato   = $input['gestor_contrato'];
                $dataAssinatura   = $input['data_assinatura'];
                $emailSolicitante = $input['email'];
                $pdf = \PDF::loadView('pdf.contratos_consultas_exames_hmr_arruda', compact('input','unidade','unidadeSobGestao','enderecoUnidade','cnpjUnidade','nomeEmpresa', 'cnpjEmpresa','enderecoEmpresa','especialidade','numConsultas','valorConsulta', 'prazoVigencia', 'inicioContrato', 'gestorContrato', 'dataAssinatura', 'emailSolicitante'))->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);;
                $pdf->setPaper('A4', 'landscape');
                $pdf->save('../public/storage/contratos_gerados/'.$nomeDocumento.'.pdf');

                // Salvando Contrato
                $input['nome'] = $nomeDocumento;
                $input['criador'] = Auth::user()->name;
                $input['tipo_documento'] = 6;
                $input['data_criacao'] = date('Y-m-d', strtotime('now'));
                $input['arquivo'] = $nomeDocumento.'.pdf';
                $input['caminho_arquivo'] = 'storage/contratos_gerados/'.$nomeDocumento.'.pdf';
                $input['unidade_id'] = $id;
                $documentos = ContratosLayout::create($input);
                $idDoc      = DB::table('contratos_layout')->max('id');
                $input['contrato_id'] = $idDoc;
                $contratoCEHA = ContratoConsultasExamesHmrArruda::create($input);
                return $pdf->stream($nomeDocumento.'.pdf');
            } catch(Throwable $e) {
                return redirect()->back()
                    ->withErrors($e)
                    ->withInput(session()->flashInput($request->input()));
            }
        }
    }
}
