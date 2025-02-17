<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Aditivo;
use App\Models\Cotacao;
use App\Models\Unidade;
use App\Models\Prestador;
use App\Models\Processos;
use App\Models\ProcessoArquivos;
use App\Models\Gestor;
use App\Models\GestorContrato;
use App\Models\RegulamentosContratos;
use App\Models\LoggerUsers;
use App\Models\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use App\Imports\processoImport;
use App\Exports\RelatorioContratoPJ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ContratacaoController extends Controller
{
	public function __construct(Unidade $unidade, Contrato $contrato, Prestador $prestador, Cotacao $cotacao, LoggerUsers $loggerUsers, Aditivo $aditivo, Processos $processos, ProcessoArquivos $processo_arquivos)
	{
		$this->unidade     = $unidade;
		$this->contrato    = $contrato;
		$this->prestador   = $prestador;
		$this->cotacao     = $cotacao;
		$this->loggerUsers = $loggerUsers;
		$this->aditivo 	   = $aditivo;
		$this->processos   = $processos;
		$this->processo_arquivos = $processo_arquivos;
	}

	public function index(Unidade $unidade)
	{
		$unidades = Unidade::all();
		return view('transparencia.contrato', compact('unidades'));
	}

	public function contratacaoCadastro($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->select(
				'contratos.id as ID',
				'contratos.*',
				'prestadors.prestador as nome',
				'prestadors.*',
				'contratos.inativa as inativa'
			)
			->where('contratos.unidade_id', $id)
			->orderBy('nome', 'ASC')
			->get();
		$aditivos    = Aditivo::where('unidade_id', $id)->orderBy('vinculado','ASC')->orderBy('id', 'ASC')->get();
		$lastUpdated = $contratos->max('updated_at');
		$processos   = Processos::where('unidade_id', $id)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'aditivos', 'lastUpdated', 'processos', 'processo_arquivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function addCotacao($id, Request $request)
	{
		$unidades = Unidade::all();
		$unidade  = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu'));
	}

	public function arquivosCotacoes($id, $id_processo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id);
		$unidadesMenu = $unidades;
		$processo = Processos::where('unidade_id', $id)->where('id', $id_processo)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidades', 'unidade', 'unidadesMenu', 'processo', 'processo_arquivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function validarCotacoes($id, $id_processo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id);
		$unidadesMenu = $unidades;
		$cotacoes  = Cotacao::find($id_processo);
		DB::statement('UPDATE cotacaos SET validar = 0 WHERE id = ' . $id_processo . ';');
		$cotacoes  = Cotacao::where('unidade_id', $id)->get();
		if ($validacao == 'ok') {
			$validator = 'Cotação Válidado com sucesso!';
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'permissao_users'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeArquivoCotacao($id, $id_processo, Request $request)
	{
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
		$cotacoes  = Cotacao::find($id_processo);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id);
		$unidadesMenu = $unidades;
		$processos = Processos::where('unidade_id', $id)->where('id', $id_processo)->paginate(15);
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:255',
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'processos', 'cotacoes', 'processo_arquivos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$solicitacao = $input['numeroSolicitacao'];
			$nome = $_FILES['file_path']['name'];
			$request->file('file_path')->move('../public/storage/cotacoes/arquivos/' . $solicitacao . '/', $nome);
			$input['file_path'] = 'cotacoes/arquivos/' . $solicitacao . '/' . $nome;
			$input['processo_id'] = $id_processo;
			ProcessoArquivos::create($input);
			$id_reg = ProcessoArquivos::all()->max('id');
			$input['registro_id'] = $id_reg;
			$log = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
			$validator = 'Arquivo da cotação cadastrado com sucesso!';
			return view('transparencia/contratacao/cotacao_arquivos_novo', compact('unidade', 'unidades', 'unidadesMenu', 'processos', 'cotacoes', 'processo_arquivos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeExcelCotacao($id, Request $request)
	{
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$processos = Processos::where('unidade_id', $id)->get();
		$nome = $_FILES['file_path']['name'];
		$extensao  = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo do Contrato!';
			return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if (($extensao === 'csv') || ($extensao === 'xls') || ($extensao === 'xlsx')) {
				$validator = Validator::make($request->all(), [
					'file_path' => 'required',
				]);
				if ($validator->fails()) {
					return view('transparencia/contratacao/contacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
		  				 ->withErrors($validator)
						 ->withInput(session()->flashInput($request->input()));
				} else {
					$processosA = Processos::where('unidade_id', $id)->get();
					$qtdA = sizeof($processosA);
					\Excel::import(new processoImport($id), $request->file('file_path'));
					$processosD = Processos::where('unidade_id', $id)->get();
					$qtdD = sizeof($processosD);
					if ($qtdA == $qtdD) {
						$validator = 'Erro ao salvar processo! O número do protocolo já existe!';
						return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
							->withErrors($validator)
							->withInput(session()->flashInput($request->input()));
					}
					$cotacoes     = Cotacao::where('unidade_id', $id)->get();
					$contratos    = Contrato::where('unidade_id', $id)->get();
					$processos    = Processos::where('unidade_id', $id)->get();
					$regulamentos = RegulamentosContratos::all();
					$lastUpdated  = $contratos->max('updated_at');
					$aditivos     = Aditivo::where('unidade_id', $id)->get();
					$permissao_users   = PermissaoUsers::where('unidade_id', $id)->get();
					$processo_arquivos = ProcessoArquivos::where('unidade_id', $id)->get();
					$a = 0;
					return view('transparencia.contratacao', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'aditivos', 'lastUpdated', 'cotacoes', 'processos', 'permissao_users', 'a', 'processo_arquivos', 'regulamentos'));
				}
			} else {
				$validator = 'Só são suportados arquivos tipo: .csv, .xls, .xlsx';
				return view('transparencia/contratacao/cotacao_excel', compact('unidades', 'unidade', 'unidadesMenu', 'processos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function prestadorCadastro($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$gestores  = Gestor::where('status_gestores', 0)->get();
		if ($validacao == 'ok') {
			return view('transparencia/prestadores/contratacao_prestador_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'gestores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function cadastroContratos($id_unidade, Contrato $contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$vinculos  = Aditivo::where('vinculado')->get();
		$gestores  = Gestor::where('status_gestores', 0)->get();
		$CP = array();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'vinculos', 'CP', 'gestores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarContratos($id_unidade, $id_prestador, $id_contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->get();
		$aditivos  = Aditivo::where('unidade_id', $id_unidade)->where('contrato_id', $id_contrato)->get();
		$prestadores = Prestador::where('id', $id_prestador)->get();
		$gestores  = Gestor::where('gestor.status_gestores', 0)->get();
		$gestor    = DB::table('gestor_contrato')
						  ->join('gestor','gestor.id','=','gestor_contrato.gestor_id')
						  ->where('contrato_id',$id_contrato)->where('gestor.status_gestores', 0)->get();
		$ccontratos  = DB::table('contratos')
			->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
			->select('contratos.id', 'contratos.prestador_id', 'contratos.unidade_id', 'aditivos.id', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf')
			->where('contratos.unidade_id', '=', $id_unidade)
			->where('contratos.prestador_id', '=', $id_prestador)
			->where('aditivos.opcao', '=', '0')
			->get();
		$vinculos = DB::table('contratos')
			->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
			->select('contratos.id', 'aditivos.contrato_id as cont_id', 'contratos.prestador_id as prestador_ID', 'contratos.unidade_id', 'aditivos.file_path', 'aditivos.id as aditivo_ID', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf', 'aditivos.vinculado', 'aditivos.ativa as ativa', 'aditivos.inativa as inativa')
			->where('contratos.unidade_id', '=', $id_unidade)
			->where('contratos.prestador_id', '=', $id_prestador)
			->orderBy('vinculado', 'ASC')
			->orderBy('aditivos.id', 'ASC')
			->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos', 'gestores', 'gestor'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function cadastroCotacoes($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes  = Cotacao::where('unidade_id', $id_unidade)->orderBy('ano','DESC')->orderBy('mes','DESC')->orderBy('proccess_name', 'ASC')->get();
		$processos = Processos::where('unidade_id', $id_unidade)->paginate(50);
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(50);
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'processos', 'processo_arquivos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function cotacoesNovo($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes  = Cotacao::where('unidade_id', $id_unidade)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function pesquisarPrestador($id_unidade, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = Unidade::all();
		$unidade 	  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$prestadores  = Prestador::all();
		$gestores     = Gestor::where('status_gestores', 0)->get();
		$lastUpdated  = $prestadores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_pesquisar_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores', 'gestores'))
				->withInput(session()->flashInput($request->input()));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function prestadorLista($id_unidade)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidades 	  = Unidade::all();
		$unidade 	  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$prestadores  = Prestador::all();
		$gestores     = Gestor::where('status_gestores', 0)->get();
		$lastUpdated  = $prestadores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/prestadores/contratacao_lista_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores', 'gestores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function responsavelCadastro($id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades     = Unidade::all();
		$unidade      = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$gestores     = Gestor::all();
		$lastUpdated  = $gestores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'gestores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function prestadorAlterar($id_unidade, $id_prestador)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades     = Unidade::all();
		$unidade      = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$prestadores  = Prestador::where('id', $id_prestador)->get();
		$lastUpdated  = $prestadores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/prestadores/contratacao_alterar_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function updatePrestador($id_unidade, $id_prestador, Request $request)
	{
		$unidades	  = Unidade::all();
		$unidade	  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input 		  = $request->all();
		$prestadores  = Prestador::where('id', $id_prestador)->get();
		$validator = Validator::make($request->all(), [
			'prestador' => 'required|max:255',
			'cnpj_cpf'  => 'required|min:14|max:18'
		]);
		if ($validator->fails()) {
			return view('transparencia/prestadores/contratacao_alterar_prestador', compact('unidade', 'unidades', 'unidadesMenu', 'prestadores'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		} else {
			$input['status_prestadors'] = 0;
			$prestador = Prestador::create($input);
			$id_reg    = Prestador::all()->max('id');
			$input['registro_id'] = $id_reg;
			$log 		 = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$prestadores = Prestador::all();
			$validator   = 'Prestador alterado com sucesso!';
			return view('transparencia/prestadores/contratacao_lista_prestador', compact('unidade', 'unidades', 'unidadesMenu', 'prestadores'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function prestadorInativar($id_unidade, $id_prestador)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades     = Unidade::all();
		$unidade      = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$prestadores  = Prestador::where('id', $id_prestador)->get();
		$lastUpdated  = $prestadores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/prestadores/contratacao_inativar_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function inativarPrestador($id, $id_prestador, Request $request)
    {
		$input     = $request->all();
		$prestador = Prestador::where('id',$id_prestador)->get();
		if($prestador[0]->status_prestadors == 1) {
			DB::statement('UPDATE prestadors SET status_prestadors = 0 WHERE id = '.$id_prestador.';');
		} else {
			DB::statement('UPDATE prestadors SET status_prestadors = 1 WHERE id = '.$id_prestador.';');
		}
		$input['registro_id'] = $id_prestador;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id);
		$prestadores  = Prestador::where('status_prestadors',1)->where('id', $id_prestador)->get();
		$validator = 'Prestador inativado com sucesso!';
		return redirect()->route('prestadorLista', [$id])
			 ->withErrors($validator);
    }

	public function pesqPresdator($id_unidade, $id_prestador, Contrato $contrato, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$gestores  = Gestor::where('status_gestores', 0)->get();
		if ($id_prestador == "procurarPrestador") {
			$prestadores = null;
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'prestadores', 'gestores'))
				->withInput(session()->flashInput($request->input()));
		} else {
			$prestadores = Prestador::where('id', $id_prestador)->get();
			$lastUpdated = $prestadores->max('updated_at');
			//$CP = Contratos do prestador selecionado
			$CP = array();
			$contraPrest = Contrato::where('prestador_id', $id_prestador)->where('unidade_id', $id_unidade)->get();
			if (sizeof($contraPrest) > 0) {
				$contraAditoPrest = Aditivo::where('contrato_id', $contraPrest[0]->id)->where('opcao', 0)->where('inativa', 0)->get();
				$qtdContratos = sizeof($contraPrest) + sizeof($contraAditoPrest);
				for ($i = 0; $i < $qtdContratos; $i++) {
					$CP[$i] = $i + 1 . "º Contrato";
				}
			}
			if ($validacao == 'ok') {
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores', 'CP', 'gestores'))
					->withInput(session()->flashInput($request->input()));
			} else {
				$validator = 'Você não tem permissão!';
				return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function procurarPrestador($id_unidade, Request $request, Contrato $contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input  = $request->all();
		$funcao = $input['funcao'];
		$pesq   = $input['pesq'];
		if ($funcao == 0) {
			if (!$pesq == "") {
				$prestadores = DB::table('prestadors')->where('prestadors.prestador','like','%'.$pesq.'%')
								  ->where('prestadors.status_prestadors', 0)->get();
				$lastUpdated = $prestadores->max('updated_at');
			} else {
				$prestadores = Prestador::all();
				$lastUpdated = $prestadores->max('updated_at');
			}
		} else if ($funcao == 1) {
			$prestadores = DB::table('prestadors')->where('prestadors.cnpj_cpf','like','%'.$pesq.'%')
							 ->where('prestadors.status_prestadors', 0)->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 2) {
			$prestadores = DB::table('prestadors')->where('prestadors.tipo_contrato','like','%'.$pesq.'%')
							  ->where('prestadors.status_prestadors', 0)->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 3) {
			$prestadores = DB::table('prestadors')->where('prestadors.tipo_pessoa','like','%'.$pesq.'%')
							 ->where('prestadors.status_prestadors', 0)->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else {
			$prestadores = Prestador::where('prestadors.status_prestadors', 0)->get();
			$lastUpdated = $prestadores->max('updated_at');
		}
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_pesquisar_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function procurarPrestadorCad($id_unidade, Request $request, Contrato $contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input  = $request->all();
		$funcao = $input['funcao'];
		$pesq   = $input['pesq'];
		if ($funcao == 0) {
			if (!$pesq == "") {
				$prestadores = DB::table('prestadors')->where('prestadors.prestador','like','%'.$pesq.'%')->get();
			} else {
				$prestadores = Prestador::all();
			}
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 1) {
			$prestadores = DB::table('prestadors')->where('prestadors.cnpj_cpf','like','%'.$pesq.'%')->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 2) {
			$prestadores = DB::table('prestadors')->where('prestadors.tipo_contrato','like','%'.$pesq.'%')->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else if ($funcao == 3) {
			$prestadores = DB::table('prestadors')->where('prestadors.tipo_pessoa','like','%'.$pesq.'%')->get();
			$lastUpdated = $prestadores->max('updated_at');
		} else {
			$prestadores = Prestador::all();
			$lastUpdated = $prestadores->max('updated_at');
		}
		if ($validacao == 'ok') {
			return view('transparencia/prestadores/contratacao_lista_prestador', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'prestadores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirAditivos($id_unidade, $id_aditivo, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		Aditivo::find($id_aditivo)->delete();
		$input = $request->all();
		$input['tela'] = 'contratacao';
		$input['acao'] = 'excluirContratacao';
		$input['user_id'] 	  = Auth::user()->id;
		$input['unidade_id']  = $id_unidade;
		$input['registro_id'] = $id_aditivo;
		$log = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidades 	  = $unidadesMenu = Unidade::all();
		$unidade 	  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$regulamentos = RegulamentosContratos::all();
		$contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
			->where('contratos.unidade_id', $id_unidade)
			->orderBy('nome', 'ASC')
			->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
		$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'permissao_users', 'aditivos', 'regulamentos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirContratos($id_unidade, $id_contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos = Contrato::where('id', $id_contrato)->get();
		$id_prestador = $contratos[0]->prestador_id;
		$aditivos  = Aditivo::where('unidade_id', $id_unidade)->where('contrato_id', $id_contrato)->get();
		$lastUpdated  = $contratos->max('updated_at');
		$regulamentos = RegulamentosContratos::all();
		$prestador = Prestador::where('id', $id_prestador)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_excluir', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'prestador', 'aditivos', 'regulamentos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function excluirCotacoes($id_unidade, $id_cotacao, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes  = Cotacao::where('id', $id_cotacao)->get();
		$lastUpdated  = $cotacoes->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_excluir', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'cotacoes'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function storePrestador($id_unidade, Request $request)
	{
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input 	   = $request->all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$validator = Validator::make($request->all(), [
			'prestador' => 'required|max:255',
			'cnpj_cpf'  => 'required|min:14|max:18'
		]);
		if ($validator->fails()) {
			return view('transparencia/prestadores/contratacao_prestador_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'contratos'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$prestador = Prestador::create($input);
			$id_reg = Prestador::all()->max('id');
			$input['registro_id'] = $id_reg;
			$log    = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$contratos   = Contrato::where('unidade_id', $id_unidade)->get();
			$validator   = 'Prestador cadastrado com sucesso!';
			return view('transparencia/prestadores/contratacao_prestador_cadastro', compact('unidade', 'unidades', 'unidadesMenu', 'contratos'))
			 	 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeGestor($id_unidade, $id_contrato, Request $request)
	{
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input     = $request->all();
		$validator = Validator::make($request->all(), [
			'nome'  => 'required|max:255',
			'email' => 'required|email'
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_responsavel_novo', compact('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			$gestor = Gestor::create($input);
			$id_reg = Gestor::all()->max('id');
			$input['registro_id'] = $id_reg;
			$log 	   = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$gestores  = Gestor::all();
			$contrato  = Contrato::where('id', $id_contrato)->get();
			$validator = 'Gestor cadastrado com sucesso!';
			return  redirect()->route('responsavelCadastro', [$id_unidade, $id_contrato])
				  ->withErrors($validator)
				  ->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato');
		}
	}

	public function validarGestorContrato($id_unidade, $id_gestor, $id_contrato, Request $request)
	{
		$unidades = Unidade::all();
		$unidade  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$hoje  = date('Y-m-d', (strtotime('now')));
		$input = $request->all();
		$input['contrato_id'] = $id_contrato;
		$input['gestor_id']   = $id_gestor;
		$gestorContrato = GestorContrato::where('contrato_id', $id_contrato)->where('gestor_id', $id_gestor)->get();
		$qtd = sizeof($gestorContrato);
		if ($qtd > 0) {
			$gestores = Gestor::all();
			$contrato = Contrato::where('id', $id_contrato)->get();
			$gestorContratos = DB::table('gestor_contrato')
				->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
				->join('unidades', 'unidades.id', '=', 'gestor_contrato.unidade_id')
				->select('gestor.nome as Nome', 'gestor_contrato.*')
				->where('gestor_contrato.contrato_id', $id_contrato)
				->where('unidade_id', $id_unidade)
				->get()->toArray();
			$lastUpdated = $gestores->max('updated_at');
			$validator = 'Gestor já vinculado para este contrato!';
			return redirect()->route('responsavelCadastro', [$id_unidade, $id_contrato])
				->withErrors($validator)
				->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato', 'gestorContratos');
		} else {
			$input['unidade_id'] = $id_unidade;
			$gestorContrato = GestorContrato::create($input);
			$lastUpdated = $gestorContrato->max('updated_at');
			$gestores = Gestor::all();
			$contrato = Contrato::where('id', $id_contrato)->get();
			$gestorContratos = DB::table('gestor_contrato')
				->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
				->select('gestor.nome as Nome', 'gestor_contrato.*')
				->where('gestor_contrato.contrato_id', $id_contrato)
				->get()->toArray();
			$validator = 'Gestor vinculado ao Contrato com sucesso!!';
			return redirect()->route('responsavelCadastro', [$id_unidade, $id_contrato])
				 ->withErrors($validator)
				 ->with('unidade', 'unidades', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato', 'gestorContratos');
		}
	}

	public function updateContratos($id_unidade, $id_prestador, $id_contrato, Request $request)
	{
		$unidades = Unidade::all();
		$unidade  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$prestadores  = Prestador::where('id', $id_prestador)->get();
		$input 		  = $request->all();
		$contratos    = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $id_prestador)->get();
		$aditivos     = Aditivo::where('unidade_id', $id_unidade)->where('opcao')->get();
		$prestadores  = Prestador::where('id', $id_prestador)->get();
		$ccontratos = DB::table('contratos')
						->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
						->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
						->select('contratos.id', 'contratos.prestador_id', 'contratos.unidade_id', 'aditivos.id', 'aditivos.opcao', 'prestadors.prestador', 'prestadors.cnpj_cpf')
						->where('contratos.unidade_id', '=', $id_unidade)
						->where('contratos.prestador_id', '=', $id_prestador)
						->where('aditivos.opcao', '=', '0')
						->get();
		$vinculos = DB::table('contratos')
						->join('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
						->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
						->select(
							'contratos.id',
							'aditivos.contrato_id as cont_id',
							'contratos.prestador_id as prestador_ID',
							'contratos.unidade_id',
							'aditivos.file_path',
							'aditivos.id as aditivo_ID',
							'aditivos.opcao',
							'prestadors.prestador',
							'prestadors.cnpj_cpf',
							'aditivos.vinculado',
							'aditivos.ativa as ativa',
							'aditivos.inativa as inativa'
						)
						->where('contratos.unidade_id', '=', $id_unidade)
						->where('contratos.prestador_id', '=', $id_prestador)
						->get();
		$validator = Validator::make($request->all(), [
			'objeto' 	=> 'required|max:255',
			'valor' 	=> 'required',
			'valor_global' => 'required',
			'inicio'    => 'required|date',
			'fim'	    => 'required|date',
			'renovacao_automatica' => 'required'
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos'))
				 ->withErrors()
				 ->withInput(session()->flashInput($request->input()));
		} else {
			$data1 = $input['inicio'];
			$data2 = $input['fim'];
			if (strtotime($data1) > strtotime($data2)) {
				$validator = 'O campo data fim, não pode ser maior que o campo data início';
				return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos'))
					 ->withErrors($validator)
					 ->withInput(session()->flashInput($request->input()));
			}
			if (isset($input['i'])) {
				$i = $input['i'];
				for ($a = 1; $a <= $i; $a++) {
					if(isset($input['cont_' . $a])){
						$vinculado = $input['cont_' . $a];
						$id		   = $input['id_' . $a];
						DB::update(DB::RAW("update aditivos set vinculado = '$vinculado' where id = " . $id));
					}
				}
			}
			$input['yellow_alert'] = 90;
			$input['red_alert']    = 60;
			if ($input['valor'] < 0) {
				$validator = 'O campo valor é inválido!';
				return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos'))
					 ->withErrors($validator)
					 ->withInput(session()->flashInput($request->input()));
			}
			if ($input['valor_global'] < 0) {
				$validator = 'O campo valor global é inválido!';
				return view('transparencia/contratacao/contratacao_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos'))
					 ->withErrors($validator)
					 ->withInput(session()->flashInput($request->input()));
			}
			if ($request->file('file_path_') !== NULL) {
				$nome = $_FILES['file_path_']['name']; 
				$extensao = pathinfo($nome, PATHINFO_EXTENSION);
				if ($extensao == 'pdf') {
					$input['ativa'] = 1;
					$qtdUnidades    = sizeof($unidades);
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
	                        $unds = Unidade::where('id',$i)->get();
						    $pasta_und = strtoupper($unds[0]->sigla);
							$prestador_nome = Prestador::where('id', $id_prestador)->get();
							$pasta_empresa  = substr($prestador_nome[0]->prestador, 0, 20)  . "-" . str_replace(['.', '/', '-'], "", $prestador_nome[0]->cnpj_cpf);
        					$pasta_empresa  = mb_convert_encoding($pasta_empresa, "UTF-8", "ISO-8859-1");
							$txt1 = $pasta_und . '/' . $pasta_empresa;
							$DateAndTime    = date('mdYhis', time()); 
							$nome = $DateAndTime .'-'. $_FILES['file_path_']['name'];
							$request->file('file_path_')->move('../public/storage/contratos/' . $txt1 . '/contratos/', $nome);
							$input['file_path'] = 'contratos/' . $txt1 . '/contratos/' . $nome;
						}
					}
				} else {
					$validator = 'Só são suportador arquivos do tipo PDF!';
					return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdate', 'vinculos', 'ccontratos', 'aditivos'))
						 ->withErrors($validator)
						 ->withInput(session()->flashInput($request->input()));
				}
			} 
			$input['prestador_id'] = $id_prestador;
			$contrato  = Contrato::find($id_contrato);
			$contrato->update($input);
			$input['contrato_id']  = $id_contrato;
			$idGestor  = $input['gestor_id'];
			$gc  = GestorContrato::where('contrato_id',$id_contrato)
								 ->where('unidade_id',$id_unidade)->get();
			$qtd = sizeof($gc);
			if ($qtd > 0) {
				if ($gc[0]->gestor_id != $idGestor) {
					DB::update(DB::RAW("update gestor_contrato set gestor_id = '$idGestor' where id = " . $gc[0]->id));
				}
			} else {
				$gestorContrato = GestorContrato::create($input);
			}
			$input['registro_id'] = $id_contrato;
			$log 	     = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$validator   = 'Dados alterados com sucesso!';
			return redirect()->route('alterarContratos', [$id_unidade, $id_prestador, $id_contrato])
				 ->withErrors($validator)
				 ->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'vinculos', 'ccontratos', 'aditivos');
		}
	}

	public function alterarAditivo($id_unidade, $id_aditivo, $id_contrato)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->where('id', $id_contrato)->get();
		$aditivos  = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get(); 
		$gestores  = DB::table('gestor_contrato')
				 	    ->join('gestor','gestor.id','=','gestor_contrato.gestor_id')
						->where('contrato_id',$id_contrato)->get();
		$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos', 'gestores'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				 ->withErrors($validator)
				 ->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateAditivo($id_unidade, $id_aditivo, $id_contrato, Request $request)
	{
		$unidades = Unidade::all();
		$unidade  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos    = Contrato::where('unidade_id', $id_unidade)->where('id', $id_contrato)->get();
		$aditivos     = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
		$prestadores  = Prestador::where('id', $contratos[0]->prestador_id)->get();
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'valor' 	=> 'required',
			'valor_global' => 'required',
			'inicio'    => 'required|date',
			'fim'		=> 'required|date',
			'renovacao_automatica' => 'required'
		]);
		if ($validator->fails()) {
			$failed = $validator->failed();
			return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
				->withErrors()
				->withInput(session()->flashInput($request->input()));
		} else {
			$data1 = $input['inicio'];
			$data2 = $input['fim'];
			if (strtotime($data1) > strtotime($data2)) {
				$validator = 'O campo data fim, não pode ser maior que o campo data início';
				return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			$input['yellow_alert'] = 90;
			$input['red_alert']    = 60;
			if ($input['valor'] < 0) {
				$validator = 'O campo valor é inválido!';
				return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			if ($input['valor_global'] < 0) {
				$validator = 'O campo valor global é inválido!';
				return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			if ($input['opcao'] == 1) {  
				if ($input['motivo'] == "0") {
					$validator = 'Informe o motivo do Aditivo!';
					return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$input['motivo'] = "";
			}
			if ($request->file('file_path_') != NULL) {
				$nome = $_FILES['file_path_']['name']; 
				$extensao = pathinfo($nome, PATHINFO_EXTENSION);
				if ($extensao == 'pdf') {
					$qtdUnidades = sizeof($unidades);
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
						    $unds 	   = Unidade::where('id',$i)->get();
						    $pasta_und = strtoupper($unds[0]->sigla);
							$pasta_empresa = substr($prestadores[0]->prestador, 0, 20)  . "-" . str_replace(['.', '/', '-'], "", $prestadores[0]->cnpj_cpf);
        					$pasta_empresa = mb_convert_encoding($pasta_empresa, "UTF-8", "ISO-8859-1");
							$txt1 = $pasta_und . '/' . $pasta_empresa;
							$tipo_doc    = ($aditivos[0]->opcao == 0 ? "contratos" : ($aditivos[0]->opcao == 1 ? "aditivos" : ($aditivos[0]->opcao == 2 ? "distratos" : "")));
							$DateAndTime = date('mdYhis', time()); 
							$nome = $DateAndTime .'-'. $_FILES['file_path_']['name'];
							$request->file('file_path_')->move('../public/storage/contratos/' . $txt1 . '/'.$tipo_doc.'/', $nome);
							$input['file_path'] = 'contratos/' . $txt1 . '/'.$tipo_doc.'/' . $nome;
						}
					}
				} else {
					$validator = 'Só são suportador arquivos do tipo PDF!';
					return view('transparencia/contratacao/contratacao_alterar_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
			$aditivos = Aditivo::find($id_aditivo);
			$aditivos->update($input);
			$input['registro_id'] = $id_aditivo;
			$log 	  = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$contratos   = Contrato::where('unidade_id', $id_unidade)->where('id', $id_contrato)->get();
			$aditivos    = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
			$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
			if ($aditivos[0]->opcao == 0) {
				$validator = 'Contrato alterado com sucesso !';
			} elseif ($aditivos[0]->opcao == 1) {
				$validator = 'Aditivo alterado com sucesso !';
			} elseif ($aditivos[0]->opcao == 3) {
				$validator = 'Rerratificação alterado com sucesso !';
			} else {
				$validator = 'Distrato alterado com sucesso !';
			}
			return redirect()->route('alterarAditivo', [$id_unidade, $id_aditivo, $id_contrato])
					->withErrors($validator)
					->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos');
		}
	}

	public function excluirAditivo($id_unidade, $id_aditivo, Request $request)
	{
		$validacao   = permissaoUsersController::Permissao($id_unidade);
		$unidades    = Unidade::all();
		$unidade     = Unidade::find($id_unidade);
		$aditivos    = Aditivo::where('id', $id_aditivo)->get();
		$contratos   = Contrato::where('unidade_id', $id_unidade)->where('id', $aditivos[0]->contrato_id)->get();
		$prestadores = Prestador::where('id', $contratos[0]->prestador_id)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_excluir_aditivo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'prestadores', 'aditivos'));
		} else {
			$validator = 'Você não tem permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeContratos($id_unidade, Request $request)
	{
		$input 	   = $request->all(); 
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$contratos = Contrato::where('unidade_id', $id_unidade)->get();
		$aditivos  = Aditivo::where('unidade_id', $id_unidade)->get();
		$CP		   = array();
		if (!empty($input['id'])) { 
			$prestadores = Prestador::where('id', $input['id'])->get(); 
			$contraPrest = Contrato::where('prestador_id', $input['id'])->where('unidade_id', $id_unidade)->get();
			if (sizeof($contraPrest) > 0) {
				$contraAditoPrest = Aditivo::where('contrato_id', $contraPrest[0]->id)->where('opcao', 0)->where('inativa', 0)->get();
				$qtdContratos = sizeof($contraPrest) + sizeof($contraAditoPrest);
				for ($i = 0; $i < $qtdContratos; $i++) {
					$CP[$i] = $i + 1 . "º Contrato";
				}
			}
		} else { 
			$prestadores = null; 
		} 
		$gestores    = Gestor::all();
		$DateAndTime = date('mdYhis', time()); 
		$nome 	   = $DateAndTime .'-'. $_FILES['file_path']['name'];
		$extensao  = pathinfo($nome, PATHINFO_EXTENSION);
		$validator = Validator::make($request->all(), [
			'objeto' => 'required|max:255',
			'valor'  => 'required',
			'inicio' => 'required|date',
			'fim'    => 'required|date'
		]);
		if ($validator->fails()) {
			return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP', 'gestores'))
				->withErrors()
				->withInput(session()->flashInput($request->input()));
		} else {
			if (empty($input['prestador'])) {
				$validator = 'Informe o Prestador!';
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP', 'gestores', 'prestadores'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			if (empty($input['gestor_id'])) {
				$validator = 'Informe o Gestor!';
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP', 'gestores', 'prestadores'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			$data1 = $input['inicio'];
			$data2 = $input['fim'];
			if (strtotime($data1) > strtotime($data2)) {
				$validator = 'O campo data fim, não pode ser maior que o campo data de início!';
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP', 'gestores'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			$input['yellow_alert'] = 90;
			$input['red_alert']    = 60;
			$input['prestador_id'] = $input['id'];
			if ($input['valor'] < 0) {
				$validator = 'O campo valor é inválido!';
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'CP', 'gestores'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			if ($input['aditivos'] !== "0" && $input['vinculado'] == "0") {
				$validator = 'Escolha um contrato para vincular o Adtivo, Distrato ou Rerratificação!';
				return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP', 'gestores'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				if ($extensao == 'pdf' || $extensao == 'PDF') {
					$qtdUnidades = sizeof($unidades);
					$nome 		 = $_FILES['file_path']['name'];
					$input['cadastro'] = 1;
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
						    $unds = Unidade::where('id', $i)->get();
						    $pasta_und = strtoupper($unds[0]->sigla);
							$prestador = $input['prestador_id'];
							$prestador_nome = Prestador::where('id', $input['prestador_id'])->get();
							$pasta_empresa  = substr($prestador_nome[0]->prestador, 0, 20)  . "-" . str_replace(['.', '/', '-'], "", $prestador_nome[0]->cnpj_cpf);
        					$pasta_empresa  = mb_convert_encoding($pasta_empresa, "UTF-8", "ISO-8859-1");
							$txt1 = $pasta_und . '/' . $pasta_empresa;
							$contratosN = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $prestador)->get();
							$qtd  		= sizeof($contratosN);
							if($qtd > 0) {
								$input['contrato_id']  = $contratosN[0]->id;
							}
							$input['aviso_venc90'] = 0;
							$input['aviso_venc60'] = 0;
							$input['inativa']      = 0;
							$input['ativa'] 	   = 0;
							if ($input['aditivos'] === '0') {
								if ($qtd > 0) {
									$request->file('file_path')->move('../public/storage/contratos/' . $txt1 . '/contratos/',  $nome);
									$input['file_path'] = 'contratos/' . $txt1 . '/contratos/'. $nome;
									$input['opcao'] = 0;
								} else {
									$request->file('file_path')->move('../public/storage/contratos/' . $txt1 . '/contratos/', $nome);
									$input['file_path'] = 'contratos/' . $txt1 . '/contratos/' . $nome;
									$input['ativa']     = 1;
								}
							} else if ($input['aditivos'] === '1') {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1 . '/aditivos/', '1-' . $nome);
								$input['file_path'] = 'contratos/' . $txt1 . '/aditivos/1-' . $nome;
								$input['opcao'] = 1;
								$fim = $input['fim'];
								DB::update(DB::RAW("update contratos set fim = '$fim' where id = " . $input['contrato_id']));
						    } else if ($input['aditivos'] === '2') {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1 . '/distratos/', '2-' . $nome);
								$input['file_path'] = 'contratos/' . $txt1 . '/distratos/2-' . $nome;
								$input['opcao'] = 2;
							} else if ($input['aditivos'] === '3') {
								$request->file('file_path')->move('../public/storage/contratos/' . $txt1 . '/distratos/', '3-' . $nome);
								$input['file_path'] = 'contratos/' . $txt1 . '/distratos/3-' . $nome;
								$input['opcao'] = 3;
							}
							if ($input['aditivos'] != 0 || ($input['aditivos'] == 0 && $qtd > 0)) {
								$aditivo = Aditivo::create($input);
								$id_reg  = Aditivo::all()->max('id');
			                    $input['registro_id'] = $id_reg;
								$log 	 = LoggerUsers::create($input);
								$lastUpdated = $log->max('updated_at');
							} else {
								if ($qtd == 0) {
									$contrato = Contrato::create($input);
									$id_reg   = Contrato::all()->max('id');
									$input['registro_id'] = $id_reg;
									$log 	  = LoggerUsers::create($input);
									$lastUpdated = $log->max('updated_at');
									$contratosN  = Contrato::where('unidade_id', $id_unidade)->where('prestador_id', $prestador)->get();
									$input['contrato_id'] = $contratosN[0]->id;
									$gestorContrato = GestorContrato::create($input);
								}
							}
						}
					}
					$contratos = DB::table('contratos')
						->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
						->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
						->where('contratos.unidade_id', $id_unidade)
						->orderBy('nome', 'ASC')
						->get();
					$aditivos = Aditivo::where('unidade_id', $id_unidade)->get();
					$permissao_users = PermissaoUsers::where('unidade_id', $id_unidade)->get();
					$a = 0;
					if ($input['aditivos'] == 0) {
						$validator = 'Contratação anexada com sucesso !';
					} elseif ($input['aditivos'] == 1) {
						$validator = 'Aditivo anexado com sucesso !';
					} elseif ($input['aditivos'] == 3) {
						$validator = 'Rerratificação anexado com sucesso !';
					} else {
						$validator = 'Distrato anexado com sucesso !';
					}
					return redirect()->route('contratacaoCadastro', [$id_unidade])
						->withErrors($validator)
						->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'lastUpdated', 'aditivos', 'permissao_users', 'a', 'gestores');
				} else {
					$validator = 'Só são suportados arquivos do tipo: .pdf!';
					return view('transparencia/contratacao/contratacao_novo', compact('unidades', 'unidade', 'unidadesMenu', 'contratos', 'CP', 'gestores', 'prestadores'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			}
		}
	}

	public function storeCotacoes($id_unidade, Request $request)
	{
		$unidades = Unidade::all();
		$unidade  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input    = $request->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$nome = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o arquivo da cotação!';
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao == 'xlsx' || $extensao == 'xls') {
				if (!empty($input['proccess_name2'])) {
					$ord = Cotacao::where('unidade_id', $id_unidade)->max('ordering');
					$ord = $ord + 1;
					$qtdUnidades = sizeof($unidades);
					$input['ordering'] = $ord;
					$input['proccess_name'] = $input['proccess_name2'];
					$input['file_name'] = $input['proccess_name'];
					$nomeCotacao = $input['proccess_name'];
					$input['validar'] = 0;
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$request->file('file_path')->move('../public/storage/cotacoes/hpr/', $nomeCotacao . '.xlsx');
							$input['file_path'] = 'cotacoes/hpr/' . $nomeCotacao . '.xlsx';
						}
					}
					$cotacao = Cotacao::create($input);
					$id_reg  = Cotacao::all()->max('id');
			        $input['registro_id'] = $id_reg;
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$cotacoes    = Cotacao::where('unidade_id', $id_unidade)->get();
					$processos   = Processos::where('unidade_id', $id_unidade)->paginate(30);
					$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(30);
					$validator   = 'Cotação cadastrada com sucesso!';
					return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated', 'processos', 'processo_arquivos'))
						 ->withErrors($validator)
						 ->withInput(session()->flashInput($request->input()));
				} else {
					$qtds = sizeof($cotacoes);
					$input['ordering'] = $qtds + 1;
					$qtdUnidades = sizeof($unidades);
					$nome = $_FILES['file_path']['name'];
					$nomeCotacao = $input['proccess_name'];
					$input['file_name'] = $nome;
					for ($i = 1; $i <= $qtdUnidades; $i++) {
						if ($unidade['id'] === $i) {
							$txt1 = $unidades[$i - 1]['path_img'];
							$txt1 = explode(".jpg", $txt1);
							$request->file('file_path')->storeAs('public/cotacoes/' . $txt1[0] . '/' . $nomeCotacao . '/', $nome);
							$input['file_path'] = 'cotacoes/' . $txt1[0] . '/' . $nome;
						}
					}
					$cotacao = Cotacao::create($input);
					$id_reg = Cotacao::all()->max('id');
			        $input['registro_id'] = $id_reg;
					$log = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
					$processos = Processos::where('unidade_id', $id_unidade)->paginate(30);
					$processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(30);
					$validator = 'Cotação cadastrada  com sucesso!';
					return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated', 'processos', 'processo_arquivos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else {
				$validator = 'Só suporta arquivos do tipo: PDF!';
				return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function destroy($id_unidade, $id_contrato, Request $request)
	{
		$input = $request->all();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)
			->where('contrato_id', $id_contrato)
			->where('vinculado', '1º Contrato')
			->get();
		$qtd = sizeof($aditivos);
		$contrato = Contrato::where('id', $id_contrato)->get();
		if ($input['statusAditivosDistratos'] == 1) {
			for ($i = 0; $i < $qtd; $i++) {
				DB::statement('UPDATE aditivos SET inativa = 2 WHERE id = ' . $aditivos[$i]->id . ';');
				$input['registro_id'] = $aditivos[$i]->id;
				$input['acao'] = "inativaDistratoAditivo";
				$log = LoggerUsers::create($input);
			}
			DB::update(DB::RAW("UPDATE contratos SET inativa = 2 WHERE id = " . $id_contrato));
			$input['registro_id'] = $id_contrato;
			$input['acao'] = "inativaContrato";
			$log = LoggerUsers::create($input);
		} else {
			DB::statement('UPDATE contratos SET inativa = 2 WHERE id = ' . $id_contrato . ';');
			$input['registro_id'] = $id_contrato;
			$input['acao'] = "inativaContrato";
			$log = LoggerUsers::create($input);
		}
		$lastUpdated  = $log->max('updated_at');
		$unidades 	  = $unidadesMenu = Unidade::all();
		$unidade      = Unidade::find($id_unidade);
		$contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
			->where('contratos.unidade_id', $id_unidade)
			->orderBy('nome', 'ASC')
			->get()->toArray();
		$aditivos  = Aditivo::where('unidade_id', $id_unidade)->get();
		$validator = 'Contrato excluído com sucesso!';
		return redirect()->route('contratacaoCadastro', [$id_unidade])
			->withErrors($validator)
			->with('unidades', 'unidade', 'unidadesMenu', 'contratos', 'aditivos', 'lastUpdated');
	}

	public function destroyCotacao($id_unidade, $id_cotacao, Cotacao $cotacao, Request $request)
	{
		Cotacao::find($id_cotacao)->delete();
		$input = $request->all();
        $input['registro_id'] = $id_cotacao;
		$log   = LoggerUsers::create($input);
		$lastUpdated = $log->max('updated_at');
		$nome 		 = $input['file_path'];
		$pasta 		 = 'public/' . $nome;
		Storage::delete($pasta);
		$unidades 	  = $unidadesMenu = Unidade::all();
		$unidade 	  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes 	  = Cotacao::where('unidade_id', $id_unidade)->get();
		$lastUpdated  = $cotacoes->max('updated_at');
		$validator	  = 'Cotação excluído com sucesso!';
		return view('transparencia/contratacao/contratacao_cotacoes_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'cotacoes'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}

	public function destroyAditivo($id_unidade, $id_aditivo, Request $request)
	{
		$input	  = $request->all();
		$aditivos = Aditivo::where('unidade_id', $id_unidade)->where('id', $id_aditivo)->get();
		$contrato = Contrato::where('id', $aditivos[0]->contrato_id)->get();
		$id_contrato   = $contrato[0]->id;
		$id_prestador  = $contrato[0]->prestador_id;
		DB::statement('UPDATE aditivos SET inativa = 2 WHERE id = ' . $id_aditivo . ';');
		$input['tela'] = 'contratacao';
		$input['acao'] = $input['statusMudanca'];
		$input['registro_id'] = $id_aditivo;
		$input['user_id']     = Auth::user()->id;
		$input['unidade_id']  = $id_unidade;
		$log = LoggerUsers::create($input);
		$validator = "Aditivo excluido com sucesso";
		return  redirect()->route('alterarContratos', [$id_unidade, $id_prestador, $id_contrato])
			  ->withErrors($validator);
	}
		
	public function ProcessContrataTerceirosCreate($id_unidade)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = $unidadesMenu = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes  = Cotacao::where('unidade_id', $id_unidade)->where('status_cotacao', 1)->get();
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_contrataTerceiros_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator);
		}
	}

	public function storeProcessContrataTerceiros($id_unidade, Request $request)
	{
		$unidades = Unidade::all();
		$unidade  = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$input 	  = $request->all();
		$cotacoes = Cotacao::where('unidade_id', $id_unidade)->get();
		$nome 	  = $_FILES['file_path']['name'];
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
		if ($request->file('file_path') === NULL) {
			$validator = 'Informe o processo de contratação de terceiros !';
			return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes', 'lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if ($extensao == 'PDF' || $extensao == 'pdf') {
				$hash = rand();
				$hash = md5($hash);
				$hash = substr($hash, 0, 5);
				$nome = $hash . "-" . $nome;
				$request->file('file_path')->move('../public/storage/cotacoes/' . $unidade->sigla . '/', $nome);
				$input['file_path'] = 'cotacoes/' . $unidade->sigla . '/' . $nome;
				$ord = Cotacao::where('unidade_id', $id_unidade)->max('ordering');
				$ord = $ord + 1;
				$input['ordering'] = $ord;
				$input['unidade_id'] = $id_unidade;
				$input['file_name'] = $nome;
				$cotacao = Cotacao::create($input);
				$input['tela'] = "Processo de contratacao de terceiros";
				$input['acao'] = "Publicação de documento";
				$input['user_id'] = Auth::user()->id;
				$id_reg = Cotacao::all()->max('id');
			    $input['registro_id'] = $id_reg;
				$log = LoggerUsers::create($input);
				$validator = "Processo de contratação de terceiros cadastrado";
				return  redirect()->route('cadastroCotacoes', [$id_unidade])
					->withErrors($validator);
			} else {
				$validator = 'Só é permitido arquivo PDF !';
				return view('transparencia/contratacao/contratacao_cotacoes_novo', compact('unidades', 'unidade', 'unidadesMenu', 'cotacoes'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function excluirProcessos($id_unidade, $id_cotacao, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = $unidadesMenu = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes  = Cotacao::where('id', $id_cotacao)->get();
		$lastUpdated  = $cotacoes->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_cotacoes_excluir', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'cotacoes'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroyProcessos($id_unidade, $id_cotacao)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = $unidadesMenu = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$cotacoes  = Cotacao::where('id', $id_cotacao)->get();
		if (sizeof($cotacoes) == 0) {
			return  redirect()->route('cadastroCotacoes', [$id_unidade]);
		} else {
			if ($cotacoes[0]->status_cotacao == 1) {
				$nome = $cotacoes[0]->file_name;
				if (stripos($cotacoes[0]->file_path, 'http') === false) {
					$origemarq = '../public/storage/' . $cotacoes[0]->file_path;
					$nome = substr($nome, 6, 300);
				} else {
					$origemarq = $cotacoes[0]->file_path;
					$nome = $cotacoes[0]->file_name;
				}
				$hash = rand();
				$hash = md5($hash);
				$hash = substr($hash, 0, 5);
				$nome = $hash . "-" . $nome;
				$destination = '../public/storage/cotacoes/trash/' . $unidade->sigla . '/' . $nome;
				$diretorio = '../public/storage/cotacoes/trash/' . $unidade->sigla . '/';
				if (!file_exists($diretorio)) {
					mkdir('../public/storage/cotacoes/trash/' . $unidade->sigla . '/', 0777, true);
				}
				if (stripos($cotacoes[0]->file_path, 'http') === false) {
                    copy($origemarq, $destination);
                    unlink($origemarq);
				} 
				$input['status_cotacao'] = 0;
				$input['file_name'] = $nome;
				$input['file_path'] = "cotacoes/trash/" . $unidade->sigla . "/". $nome;
			} else {	
				$nome = $cotacoes[0]->file_name;
				if (stripos($cotacoes[0]->file_path, 'http') === false) {
					$origemarq = '../public/storage/' . $cotacoes[0]->file_path;
				} else {
					$origemarq = $cotacoes[0]->file_path;
				}
				$nome = substr($nome, 6, 300);
				$hash = rand();
				$hash = md5($hash);
				$hash = substr($hash, 0, 5);
				$nome = $hash . "-" . $nome;
				$destination = '../public/storage/cotacoes/' . $unidade->sigla . '/' . $nome;
				$diretorio = '../public/storage/cotacoes/' . $unidade->sigla . '/';
				if (!file_exists($diretorio)) {
					mkdir('../public/storage/cotacoes/' . $unidade->sigla . '/', 0777, true);
				}
				copy($origemarq, $destination);
				if (stripos($cotacoes[0]->file_path, 'http') === false) {
					unlink($origemarq);
				}
				$input['status_cotacao'] = 1;
				$input['file_name'] = $nome;
				$input['file_path'] = "cotacoes/" . $unidade->sigla . "/". $nome;
			}
			$cotacoes = Cotacao::where('id', $id_cotacao);
			$cotacoes->update($input);
			$id_bem_publico = $id_cotacao;
			$input['tela'] = "ProcessoContratacaoTerceiros";
			$input['acao'] = "Inativar";
			$input['user_id'] = Auth::user()->id;
			$input['unidade_id'] = $id_unidade;
			$input['registro_id'] = $id_cotacao;
			$log = LoggerUsers::create($input);
			$validator = "Documento excluido com sucesso !";
			return redirect()->route('cadastroCotacoes', $id_unidade)
				->withErrors($validator);
		}
	}

	public function relatorioContratosPJ($id, $id_)
    {
		$tipoServ = '';
        if ($id_ == 1){
            $tipoServ = 'Obras';
        } elseif ($id_ == 2){
            $tipoServ = 'Servicos';
        } elseif ($id_ == 3){
            $tipoServ = 'AquisicaoDeBens';
        }
		return Excel::download(new RelatorioContratoPJ($id, $id_), "RelatorioContratoPJ".$tipoServ.".csv", \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

	public function excluirGestorContrato($id, $id_contrato, $id_gestor)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidades     = $unidadesMenu = Unidade::all();
		$unidade      = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$gestores     = Gestor::where('id', $id_gestor)->get();
		$contrato 	  = Contrato::where('id', $id_contrato)->get();
		$lastUpdated  = $gestores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_responsavel_excluir', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato'));
		} else {
			$validator = 'Você não tem Permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function destroyGestorContrato($id, $id_gestor, $id_contrato, Request $request)
	{
		$input 		= $request->all();
		$gestorC    = GestorContrato::where('contrato_id',$id_contrato)
									->where('gestor_id',$id_gestor)
								    ->where('unidade_id',$id)->get();
		$idGC 		= $gestorC[0]->id;
		GestorContrato::find($idGC)->delete();
		$input['registro_id'] = $idGC;
		$input['unidade_id']  = 1;
		$log 		  = LoggerUsers::create($input);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id);
		$validator 	  = 'Gestor desvinculado do Contrato com sucesso!';
		$gestores 	  = Gestor::all();
		$contrato 	  = Contrato::where('id', $id_contrato)->get();
		$gestorContratos = DB::table('gestor_contrato')
			->join('gestor', 'gestor_contrato.gestor_id', '=', 'gestor.id')
			->join('unidades', 'unidades.id', '=', 'gestor_contrato.unidade_id')
			->select('gestor.nome as Nome', 'gestor_contrato.*', 'gestor.id as idG')
			->where('gestor_contrato.contrato_id', $id_contrato)
			->where('unidade_id', $id)
			->get()->toArray();
		$lastUpdated = $gestores->max('updated_at');
		return view('transparencia/contratacao/contratacao_responsavel_cadastro', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'gestores', 'contrato', 'gestorContratos'));
	}

	public function contratacaoDuvidas($id) 
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidades     = Unidade::all();
		$unidade      = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$gestores 	  = Gestor::all();
		$lastUpdated  = $gestores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/contratacao/contratacao_duvidas', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
}