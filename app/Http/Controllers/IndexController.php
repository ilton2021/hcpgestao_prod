<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\UnidadesCapacity;
use App\Models\UnidadesSpecialty;
use App\Models\Organizational;
use App\Models\Associado;
use App\Models\ConselhoAdm;
use App\Models\ConselhoFisc;
use App\Models\Superintendente;
use App\Models\Estatuto;
use App\Models\DocumentacaoRegularidade;
use App\Models\Type;
use App\Models\Decreto;
use App\Models\Justificativa;
use App\Models\Manual;
use App\Models\Pregao;
use App\Models\Pessoa;
use App\Models\Hierarquia;
use App\Models\Cargo;
use App\Models\ContratoGestao;
use App\Models\Despesa;
use App\Models\Ocupacao;
use App\Models\Indicador;
use App\Models\SelecaoPessoal;
use App\Models\CertificadoIntegridade;
use App\Models\AssistencialCovid;
use App\Models\Repasse;
use App\Models\Prestador;
use App\Models\PermissaoUsers;
use App\Models\ContratacaoServicos;
use App\Models\EspecialidadeContratacao;
use App\Models\Especialidades;
use App\Models\Permissao;
use App\Models\Contrato;
use App\Models\BensPublicos;
use App\Models\Competencia;
use App\Models\FinancialReport;
use App\Models\DemonstrativoFinanceiro;
use App\Models\SelectiveProcess;
use App\Models\Processos;
use App\Models\ProcessoArquivos;
use App\Models\DemonstracaoContabel;
use App\Models\Setor;
use App\Models\SetorRegulamentos;
use App\Models\Ocorrencias;
use App\Models\TiposOcorrencias;
use App\Models\OcorrenciasForm;
use App\Models\ServidoresCedidosRH;
use App\Models\Assistencial;
use App\Models\AssistencialDoc;
use App\Models\Cotacao;
use App\Models\RegimentoInterno;
use App\Models\Aditivo;
use App\Models\RelatorioFinanceiro;
use App\Models\Covenio;
use App\Models\Organograma;
use App\Models\OuvidoriaRelEstatis;
use App\Models\RegulamentosRh;
use App\Models\RegulamentosContratos;
use App\Models\ContratacaoServicosErratas;
use App\Models\Ouvidoria;
use App\Models\Documentacao;
use App\Models\TipoIncidente;
use App\Models\ProblemaTipoIncidente;
use App\Models\ProcessoTipoIncidente;
use App\Exports\AssistencialExport;
use App\Exports\AssociadosExport;
use App\Exports\ConselhoAdmExport;
use App\Exports\ConselhoFiscExport;
use App\Exports\SuperintendenteExport;
use App\Exports\RepasseExport;
use App\Exports\RepasseSomExport;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use DB;
use PDF;
use Validator;
use Auth;

class IndexController extends Controller
{
    protected $unidade;

    public function __construct(Unidade $unidade, RegimentoInterno $reg_interno)
    {
        $this->unidade 	   = $unidade;
		$this->reg_interno = $reg_interno;
    }

    public function index()
    {  
       $unidades = Unidade::all();
       return view('welcome', compact('unidades'));
    }

    public function transparenciaHome($id)
    {
		$unidadesMenu = Unidade::all();
        $unidade = Unidade::find($id);
        $lastUpdated  = $unidade->updated_at;
		$undCapacity  = UnidadesCapacity::where('unidade_id', $id)->where('status_capacity', 1)->get();
        $undSpecialty = UnidadesSpecialty::where('unidade_id', $id)->where('status_specialty', 1)->get();

        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.institucional', compact('unidade', 'unidadesMenu', 'undCapacity', 'undSpecialty', 'lastUpdated', 'permissao_users'));
    }
    
    public function transparenciaHomeOss($id)
    {
		$unidadesMenu = Unidade::all();
        $unidade = Unidade::find($id);
        $lastUpdated  = $unidade->updated_at;
        $undOss = Unidade::where('id',1)->get();
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
	    return view('transparencia.institucionalOss', compact('unidade','unidadesMenu','lastUpdated','permissao_users','undOss'));
    }
    
    public function transparenciaOuvidoria($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = Unidade::where('status_unidades', 1)->find($id);
        $lastUpdated  = $unidade->updated_at;
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $ouvidorias = Ouvidoria::where('unidade_id', $id)->where('status_ouvidoria', 1)->get();
        $relatoriosEs = OuvidoriaRelEstatis::where('unidade_id', $id)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->where('status_ouvi_rel_estas', 1)->get();
        return view('transparencia.ouvidoria', compact('unidade', 'unidadesMenu', 'lastUpdated', 'permissao_users', 'ouvidorias', 'relatoriosEs'));
    }

    public function transparenciaOuvidoriaDenuncias($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = Unidade::where('status_unidades', 1)->find($id);
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.ouvidoria_denuncias', compact('unidade', 'unidadesMenu', 'permissao_users'));
    }

    public function transparenciaOrganizacional($id)
    { 
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade = $unidadesMenu->where('status_unidades', 1)->find($id);
        if ($id == 1) {
            $estruturaOrganizacional = Organizational::where('status_organizacional',1)->where('unidade_id', 1)->get();
        } else {
            $estruturaOrganizacional = Organizational::where('status_organizacional',1)->where('unidade_id', $id)->get();
        }
        if ($unidade->id === 1) {
            $lastUpdated = $estruturaOrganizacional->max('updated_at');
        } else {
            $ultimaData = Organizational::where('status_organizacional',1)->where('unidade_id', $id)->where('updated_at', '<=', Carbon::now())->orderBy('updated_at', 'DESC')->first();
            $lastUpdated = $estruturaOrganizacional->max('updated_at');
        }
        $reg = RegimentoInterno::where('status_regimento',1)->where('unidade_id', $id)->get();
        $qtd = sizeof($reg);
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $arqOrgano = Organograma::where('status_organograma',1)->where('unidade_id', $id)->get();
        return view('transparencia.organizacional', compact('unidade', 'unidadesMenu', 'estruturaOrganizacional', 'lastUpdated', 'qtd', 'reg', 'permissao_users', 'arqOrgano'));
    }
    
    public function transparenciaOrganizacionalOss($id)
    { 
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade = $unidadesMenu->where('status_unidades', 1)->find($id);
        $estruturaOrganizacional = Organizational::where('unidade_id', 1)->get();
        $lastUpdated = $estruturaOrganizacional->max('updated_at');
        $ultimaData = Organizational::where('unidade_id', $id)->where('updated_at', '<=', Carbon::now())->orderBy('updated_at', 'DESC')->first();
        $undOss = Unidade::where('id', 1)->where('status_unidades', 1)->get();
        $reg = RegimentoInterno::where('unidade_id', 1)->get();
        $qtd = sizeof($reg);
        $permissao_users = PermissaoUsers::where('unidade_id', 1)->get();
        $arqOrgano = Organograma::where('unidade_id', 1)->get();
        return view('transparencia.organizacionalOss', compact('unidade', 'unidadesMenu', 'estruturaOrganizacional', 'lastUpdated', 'qtd', 'reg', 'permissao_users', 'arqOrgano', 'undOss'));
    }

    public function transparenciaMembros($id,$escolha)
    {
        $unidadesMenu  = Unidade::all();
        $unidade       = $unidadesMenu->find($id);
        $undOss        = Unidade::where('id',1)->get();
        $associados    = Associado::where('unidade_id', 1)->where('status_associados', 1)->get();
        $conselhoAdms  = ConselhoAdm::where('unidade_id', 1)->where('status_conselho_adms', 1)->get();
        $conselhoFiscs = ConselhoFisc::where('unidade_id', 1)->where('status_conselho_fiscs', 1)->get();
        $superintendentes = Superintendente::where('unidade_id', 1)->where('status_superintendentes', 1)->get();
        $datas = array();
        $datas[] = $associados->max('updated_at');
        $datas[] = $conselhoAdms->max('updated_at');
        $datas[] = $conselhoFiscs->max('updated_at');
        $datas[] = $superintendentes->max('updated_at');
        $lastUpdated = max($datas);
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.membros', compact('unidade','unidadesMenu','associados','conselhoAdms','conselhoFiscs','superintendentes','escolha','lastUpdated','permissao_users','undOss'));
    }

	public function transparenciaAlterarMembros($idM,$escolha)
	{
		$associados = Associado::where('unidade_id', $idM)->get();
		$unidade = new Unidade();
		$unidades = Unidade::find($associados->find($associados));
		return view('transparencia.membros.associados', compact('unidades','associados','escolha'));
	}

	public function salvar($id)
	{
		$unidade = new Unidade();
		$unidade = Unidade::find($id);
		return view('welcome', compact('unidade'));
	}
		
    public function exportAssociados() 
    {
        return (new AssociadosExport)->download('associados.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }
	
	public function repassesSomExport($id, $year)
	{
		return Excel::download(new RepasseSomExport($id, $year), 'repasse_som.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
	}

    public function exportConselhoAdm() 
    {
        return (new ConselhoAdmExport)->download('conselhoadm.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }
    
    public function rp()
    {
        $hoje = date('Y-m-d', strtotime('now'));
        $where = '(contratacao_servicos.prazoInicial <= CURDATE() and (contratacao_servicos.prazoFinal >= CURDATE() or contratacao_servicos.prazoFinal is null)) or contratacao_servicos.prazoProrroga >= CURDATE()';
        $contratacao_servicos = DB::table('contratacao_servicos')
            ->join('unidades', 'unidades.id', '=', 'contratacao_servicos.unidade_id')
            ->whereRaw($where)
            ->select(
                'unidades.path_img as path_img',
                'contratacao_servicos.tipoPrazo as tipoPrazo',
                'contratacao_servicos.prazoInicial as prazoInicial',
                'contratacao_servicos.prazoFinal as prazoFinal',
                'contratacao_servicos.id as id',
                'contratacao_servicos.prazoProrroga as prazoProrroga',
                'unidades.sigla as nomeUnidade',
                'unidades.id as idUnidade',
                'contratacao_servicos.titulo as titulo',
                'contratacao_servicos.status as status'
            )
            ->orderBy('unidades.sigla', 'ASC')
            ->get();
        $count = sizeof($contratacao_servicos);
        $unidades = Unidade::all();
        $countUnd = sizeof($unidades);
        $und1 = 0; $und2 = 0; $und3 = 0; $und4 = 0; $und5 = 0; 
		$und6 = 0; $und7 = 0; $und8 = 0; $und9 = 0; $und10 = 0;
		for ($a = 0; $a < $count; $a++) {
			if ($contratacao_servicos[$a]->idUnidade == 1 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und1 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 2 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und2 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 3 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und3 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 4 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und4 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 5 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und5 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 6 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und6 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 7 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und7 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 8 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und8 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 9 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und9 += 1;
			} else if ($contratacao_servicos[$a]->idUnidade == 10 && ($contratacao_servicos[$a]->prazoFinal <= $hoje || $contratacao_servicos[$a]->prazoProrroga <= $hoje)) {
				$und10 += 1;
			}
		} 
		return view('rp', compact('unidades', 'contratacao_servicos', 'count', 'countUnd','und1','und2','und3','und4','und5','und6','und7','und8','und9','und10'));
    }

    public function rp2($id)
    {
        $now = date('Y-m-d', strtotime('now'));
        $contratacao_servicos = DB::table('contratacao_servicos')
            ->join('unidades', 'unidades.id', '=', 'contratacao_servicos.unidade_id')
            ->where('contratacao_servicos.unidade_id', $id)
            ->select(
                'unidades.path_img as path_img',
                'contratacao_servicos.tipoPrazo as tipoPrazo',
                'contratacao_servicos.prazoInicial as prazoInicial',
                'contratacao_servicos.prazoFinal as prazoFinal',
                'contratacao_servicos.id as id',
                'contratacao_servicos.prazoProrroga as prazoProrroga',
                'unidades.sigla as nomeUnidade',
                'unidades.id as idUnidade',
                'contratacao_servicos.titulo as titulo',
                'contratacao_servicos.status as status'
            )
            ->orderBy('unidades.sigla', 'ASC')
            ->get(); 
        $unidades = Unidade::where('id', $id)->get();
        $especialidades = Especialidades::where('nome','<>',"")->get();
        $especialidade_contratacao = EspecialidadeContratacao::all();
        $contratacao_erratas = ContratacaoServicosErratas::all();
        return view('rp2', compact('contratacao_servicos','unidades','especialidades','especialidade_contratacao','contratacao_erratas'));
    }
    
    public function rp3($id_u, $id)
    {
        $contratacao_servicos = ContratacaoServicos::where('id',$id)->get();
        $unidades   = Unidade::where('id',$id_u)->get();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id',$id)->get();
        $especialidades = Especialidades::where('nome','<>',"")->get();
        $contratacao_erratas = ContratacaoServicosErratas::where('contratacao_servicos_id', $id)->get();
        return view('rp3', compact('contratacao_servicos','contratacao_erratas','unidades','especialidade_contratacao','especialidades'));
    }
    
    public function rp4($id)
    {
        return view('rp4');
    }

    public function exportConselhoFisc() 
    {
       return (new ConselhoFiscExport)->download('conselhofisc.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function exportSuperintendente() 
    {
        return (new SuperintendenteExport)->download('superintendentes.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function transparenciaEstatuto($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades', 1)->find($id);
        $undOss       = Unidade::where('id', 1)->where('status_unidades', 1)->get();
        $estatutos    = Estatuto::where('status_estatuto',1)->orderby('year', 'ASC')->get();
        $lastUpdated  = $estatutos->where('status_estatuto',1)->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.estatuto', compact('unidade', 'unidadesMenu', 'estatutos', 'lastUpdated', 'permissao_users', 'undOss'));
    }

    public function transparenciaDocumento($id, $escolha)
    {
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
        $unidade      = $unidadesMenu->where('status_unidades',1)->find($id);
        $undOss       = Unidade::where('id', 1)->where('status_unidades',1)->get();
        $types        = Type::all();
        $documents    = DocumentacaoRegularidade::where('status_documentos',1)->orderby('name','ASC')->get();
        $lastUpdated  = $documents->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.documentos', compact('unidade', 'unidadesMenu', 'escolha', 'documents', 'types', 'lastUpdated', 'permissao_users', 'undOss'));
    }

    public function transparenciaDecreto($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade = $unidadesMenu->where('status_unidades', 1)->find($id);
        $undOss = Unidade::where('id', 1)->where('status_unidades', 1)->get();
        $decretos = Decreto::where('status_decreto',1)->get();
        $lastUpdated = $decretos->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.decreto', compact('unidade', 'unidadesMenu', 'decretos', 'lastUpdated', 'permissao_users', 'undOss'));
    }

    public function transparenciaPregao($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        $pregaos = Pregao::all()->groupBy('ano');
        $lastUpdated = Pregao::all()->max('updated_at');
        return view('transparencia.pregao', compact('unidade','unidadesMenu','pregaos','lastUpdated'));
    }

    public function transparenciaContratoGestao($id, $escolha)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades', 1)->find($id);
        $unidades     = Unidade::where('status_unidades', 1)->get();
        if ($id == 1 || $id == 10) {
            $contratos = ContratoGestao::where('status_contratos',1)->get();
            $lastUpdated = $contratos->max('updated_at');
        } else {
            $contratos = ContratoGestao::where('status_contratos',1)->where('unidade_id', $id)->get();
            $lastUpdated = $contratos->max('updated_at');
        }
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.contratoGestao', compact('unidade', 'unidadesMenu', 'escolha', 'contratos', 'lastUpdated', 'permissao_users', 'unidades'));
    }

	public function transparenciaCovenio($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        $covenios = Covenio::all();
        $lastUpdated = $covenios->max('updated_at');
        return view('transparencia.covenio', compact('unidade','unidadesMenu','covenios','lastUpdated'));
    }

    public function transparenciaContasAtual($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.contasAtual', compact('unidade','unidadesMenu'));
    }

    public function transparenciaRelMensalExecucao($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.relatorioMensalExecucao', compact('unidade','unidadesMenu'));
    }

    public function transparenciaMensalFinanceiroExercico($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.relatorioMensalFinanceiro', compact('unidade','unidadesMenu'));
    }

    public function transparenciaProcessoCotacao($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        return view('transparencia.processoCotacao', compact('unidade','unidadesMenu'));
    }

    public function transparenciaDespesas($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        $tableFill = DB::table('employees')
        ->join('unidades', 'employees.unidade_id', '=', 'unidades.id')
        ->join('area_ocupacaos', 'employees.area_ocupacao_id', '=', 'area_ocupacaos.id')
        ->join('ocupacaos', 'employees.ocupacao_id', '=', 'ocupacaos.id')
        ->join('regime_trabalhos', 'employees.regime_id', '=', 'regime_trabalhos.id')
        ->select('unidades.cnpj', 'unidades.name as unidade', 'employees.*','area_ocupacaos.title','regime_trabalhos.title as regime','ocupacaos.cbo')
        ->get()->toArray();
        $tableFillValues = DB::table('vencimento_vantagems')->get();
        return view('transparencia.despesas', compact('unidade','unidadesMenu','tableFill','tableFillValues'));
    }

    public function transparenciaRegulamento($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades', 1)->find($id);
        $undOss       = Unidade::where('id', 1)->where('status_unidades', 1)->get();
        $idund        = $id;
        $manuais      = Manual::where('status_manuais',1)->get();
        $lastUpdated  = $manuais->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $setores      = SetorRegulamentos::all();
        return view('transparencia/regulamento', compact('unidade', 'unidadesMenu', 'manuais', 'lastUpdated', 'permissao_users', 'undOss', 'idund', 'setores'));
    }

    public function transparenciaAssistencial($id)
    {
        $unidadesMenu      = Unidade::where('status_unidades', 1)->get();
        $unidade           = $unidadesMenu->where('status_unidades', 1)->find($id);
        $anosRef           = Assistencial::where('unidade_id', $id)->where('status_assistencials', 1)->orderBy('ano_ref', 'ASC')->pluck('ano_ref')->unique();
        $anosRefDoc        = AssistencialDoc::where('unidade_id', $id)->where('status_ass_doc', 1)->orderBy('ano', 'ASC')->pluck('ano')->unique();
        $anosRef           = json_decode($anosRef, true);
        $anosRefDoc        = json_decode($anosRefDoc, true);
        $anosRef           = array_merge($anosRef, $anosRefDoc);
        asort($anosRef);
        $anosRef           = array_unique($anosRef);
        $permissao_users   = PermissaoUsers::where('unidade_id', $id)->get();
        $lastUpdates       = array();
        $assistencialCovid = AssistencialCovid::where('status_assistencial_covid',1)->get();
        $assistencial      = Assistencial::where('unidade_id', $id)->where('status_assistencials',1)->get();
        $assistenDocs      = AssistencialDoc::where('unidade_id', $id)->where('status_ass_doc',1)->get();
        array_push($lastUpdates, 
        $assistencial      ->max('created_at'),
        $assistencial      ->max('updated_at'),
        $assistenDocs      ->max('created_at'),
        $assistenDocs      ->max('updated_at')
        );
        $lastUpdated       = max($lastUpdates);
        $anosRefDocs       = AssistencialDoc::where('unidade_id', $id)->where('status_ass_doc',1)->orderBy('ano', 'ASC')->get();
        return view('transparencia.assistencial', compact('unidade', 'unidadesMenu', 'lastUpdated', 'anosRef', 'anosRefDocs',  'assistenDocs', 'permissao_users', 'assistencialCovid', 'anosRefDoc'));
    }

    public function visualizarAssistencial($id)
	{
	   if (!empty($_GET['year'])) {
            $ano = $_GET['year'];
            $unidadesMenu = Unidade::where('status_unidades', 1)->get();
            $unidade = $unidadesMenu->where('status_unidades', 1)->find($id);
            $assistencialCovid = AssistencialCovid::where('status_assistencial_covid', 1)->get();
            $anosRefDocs = AssistencialDoc::where('unidade_id', $id)->where('status_ass_doc', 1)->where('ano', $ano)->get();
            $anosRef = Assistencial::where('unidade_id', $id)->where('status_assistencials', 1)->where('ano_ref', $ano)->get();
            $lastUpdated = '2020-06-15 10:00:00';
            $assistenDocs = AssistencialDoc::where('unidade_id', $id)->where('ano', $ano)->where('status_ass_doc', 1)->get();
            $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
            if ((sizeof($anosRef) > 0) || (sizeof($assistenDocs) > 0)) {
                return view('transparencia/assistencial/assistencial_visualizar', compact('unidade', 'unidadesMenu', 'assistenDocs', 'lastUpdated', 'anosRef', 'anosRefDocs'));
            } else {
                return view('transparencia.assistencial', compact('unidade', 'unidadesMenu', 'lastUpdated', 'anosRef', 'anosRefDocs',  'assistenDocs', 'permissao_users', 'assistencialCovid'));
            }
        } else {
            $unidadesMenu = Unidade::where('status_unidades', 1)->get();
            $unidade = $unidadesMenu->where('status_unidades', 1)->find($id);
            $anosRef = Assistencial::where('unidade_id', $id)->where('ano_ref', $ano)->get();
            $lastUpdated = '2020-06-15 10:00:00';
            return view('transparencia/assistencial/assistencial_visualizar', compact('unidade', 'unidadesMenu', 'lastUpdated', 'anosRef'));
        }
	}

    public function exportAssistencialMensal($id, $year)
    {
        return Excel::download(new AssistencialExport($id,$year), 'assistencial.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function exportAssistencialAnual($id)
    {
        return Excel::download(new AssistencialExport($id, 0), 'assistencial.xlsx');
    }
	
    public function transparenciaInstitucionalPdf($id)
    {
        $unidade = Unidade::find($id);
        return PDF::loadView('transparencia.pdf.institucional', compact('unidade'))
        ->download('institucional-'.$unidade->name.'.pdf');
    }

    public function transparenciaCompetencia($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades', 1)->find($id);
        $competenciasMatriz = Competencia::where('unidade_id', $id)->where('status_competencias', 1)->get();
        $lastUpdated     = $competenciasMatriz->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.competencia', compact('unidade', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated', 'permissao_users'));
    }

    public function transparenciaFinanReports($id)
    {
        $unidadesMenu    = Unidade::where('status_unidades', 1)->get();
        $unidade         = $unidadesMenu->where('status_unidades', 1)->find($id);
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $relatorioFinanceiro = RelatorioFinanceiro::where('status_financeiro',1)->where('unidade_id', $id)->orderBy('ano', 'ASC')->get();
        $lastUpdated     = $relatorioFinanceiro->max('updated_at');
        return view('transparencia.financeiro', compact('unidade', 'unidadesMenu', 'permissao_users', 'relatorioFinanceiro', 'lastUpdated'));
    }

    public function transparenciaDemonstrative($id)
    {
        $unidadesMenu     = Unidade::where('status_unidades', 1)->get();
        $unidade          = $unidadesMenu->where('status_unidades', 1)->find($id);
        $financialReports = DemonstrativoFinanceiro::where('status_financeiro',1)->where('unidade_id', $id)->orderBy('ano', 'ASC')->orderBy('mes', 'ASC')->orderBy('title', 'ASC')->get();
        $lastUpdated      = $financialReports->max('updated_at');
        $permissao_users  = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.demonstrativo', compact('unidade', 'unidadesMenu', 'financialReports', 'lastUpdated', 'permissao_users'));
    }

    public function transparenciaAccountable($id)
    {
        $unidadesMenu           = Unidade::where('status_unidades', 1)->get();
        $unidade                = $unidadesMenu->where('status_unidades', 1)->find($id);
        $demonstrativoContaveis = DemonstracaoContabel::where('status_contabel',1)->where('unidade_id', $id)->get();
        $lastUpdated            = $demonstrativoContaveis->max('updated_at');
        $permissao_users        = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.accountable', compact('unidade', 'unidadesMenu', 'demonstrativoContaveis', 'lastUpdated', 'permissao_users'));
    }

    public function transparenciaRepasses($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades', 1)->find($id);
        $repasses = Repasse::where('status_repasse',1)->where('unidade_id', $id)->orderBy('ano', 'ASC')->get();
        $anoRepasses  = $repasses->pluck('ano')->unique();
        $mesRepasses  = $repasses->pluck('mes')->unique();
        $mesUpdate    = $repasses->where('ano', $anoRepasses->last())->pluck('mes')->last();
        function valorMes($month)
        {
            $monthArray = array(
                "1" => "janeiro",
                "2" => "fevereiro",
                "3" => "marco",
                "4" => "abril",
                "5" => "maio",
                "6" => "junho",
                "7" => "julho",
                "8" => "agosto",
                "9" => "setembro",
                "10" => "outubro",
                "11" => "novembro",
                "12" => "dezembro",
            );
            return array_search($month, $monthArray);
        };
        $lastUpdated     = $repasses->max('updated_at');
        $somContratado   = $repasses->sum('contratado');
        $somRecebido     = $repasses->sum('recebido');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.repasses', compact('unidade', 'unidadesMenu', 'somContratado', 'somRecebido', 'anoRepasses', 'mesRepasses', 'lastUpdated', 'permissao_users', 'repasses'));
    }

    public function repassesExport($id, $year)
    {
        return Excel::download(new RepasseExport($id,$year), 'repasse.csv', \Maatwebsite\Excel\Excel::CSV, [
              'Content-Type' => 'text/csv',
        ]);
    }

    public function transparenciaContratacao($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade = $unidadesMenu->find($id);
        $regulamentos = RegulamentosContratos::where('status',1)->get();
        $contratos = DB::table('contratos')
            ->Join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
            ->select('contratos.id as ID', 'contratos.*','contratos.inativa as inativa', 'prestadors.prestador as nome', 'prestadors.*')
            ->where('contratos.unidade_id', $id)
            ->whereIn('inativa', [0,1])
            ->orderBy('nome', 'ASC')->get();
        $aditivos = Aditivo::where('unidade_id', $id)->whereIn('inativa', [0,1])
        ->orderBy('vinculado', 'ASC')->orderBy('id', 'ASC')->get();
        $cotacoes = Cotacao::where('unidade_id', $id)->orderBy('ano','DESC')->orderBy('mes','DESC')->orderBy('proccess_name', 'ASC')->where('status_cotacao', 1)->get();
        $lastUpdated = $contratos->max('created_at');
        $ultimoUpdate = DB::table('contratos')
            ->Join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
            ->select('contratos.updated_at as updated_at')
            ->where('contratos.unidade_id', $id)
            ->where('prestadors.tipo_contrato', '=', 'OBRAS')
            ->orderBy('contratos.updated_at', 'DESC')
            ->limit(1)->get();
        $ultimoCreate = DB::table('contratos')
            ->Join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
            ->select('contratos.created_at as created_at')
            ->where('contratos.unidade_id', $id)
            ->where('prestadors.tipo_contrato', '=', 'OBRAS')
            ->orderBy('contratos.created_at', 'DESC')
            ->limit(1)->get();
        $prestadoresC = DB::table('contratos')
            ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
            ->select('prestadors.id as id', 'prestadors.prestador', 'prestadors.cnpj_cpf')
            ->where('contratos.unidade_id', $id)
            ->orderby('prestadors.prestador')
            ->groupby('prestadors.id','prestadors.prestador','prestadors.cnpj_cpf')
            ->get();
        if (sizeof($ultimoUpdate) !== 0 || sizeof($ultimoCreate) !== 0) {
            $m = "";
            if ($ultimoUpdate[0]->updated_at > $ultimoCreate[0]->created_at) {
                $ultimaAtualizaObras = $ultimoUpdate[0]->updated_at;
            } else {
                $ultimaAtualizaObras = $ultimoCreate[0]->created_at;
            }
        } else {
            $m = "Nao ha servicos de obras contratados pela unidade.";
            $ultimaAtualizaObras = date('Y-m-d');
        }
        $justificativaO  = Justificativa::where('unidade_id',$id)->where('tabela',2)->get();
        $justificativaA  = Justificativa::where('unidade_id',$id)->where('tabela',3)->get();
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        $prestadores = Prestador::all();
        return view('transparencia.contratacao', compact('unidade', 'unidadesMenu', 'contratos', 'cotacoes', 'aditivos', 'lastUpdated', 'permissao_users','ultimaAtualizaObras','m','justificativaO','justificativaA','regulamentos', 'prestadores', 'prestadoresC'));
    }
	
	public function pesquisarMesCotacao($id, $mes, $ano)
    {
        $unidadesMenu = Unidade::all();
        $unidade = $unidadesMenu->find($id);
        $contratos = DB::table('contratos')
        ->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
		->select('contratos.id as ID', 'contratos.*', 'prestadors.prestador as nome', 'prestadors.*')
		->where('contratos.unidade_id', $id)
		->orderBy('nome', 'ASC')
        ->get()->toArray();
		$aditivos = Aditivo::where('unidade_id', $id)->get();
		$cotacoes = Cotacao::where('unidade_id', $id)->where('status_cotacao', 1)->get();
		$processos = Processos::where('unidade_id', $id)->whereMonth('dataAutorizacao',$mes)->whereYear('dataAutorizacao', $ano)->get();
		$z = 0;
		if($ano == "2020"){ $z = 1; } else if($ano == "2021"){ $z = 2; }
		$processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
		$lastUpdated = $processo_arquivos->max('updated_at');
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$a = 1;
		return view('transparencia.contratacao', compact('unidade','unidadesMenu','contratos','cotacoes','aditivos','lastUpdated','processos','processo_arquivos','permissao_users','a','mes','z'));
    }
    
	public function transparenciaRecursosHumanos($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        $docSelectiveProcess = SelectiveProcess::where('status_processos',1)->where('unidade_id',$id)->orderBy('year','ASC')->get();
        $selecaoPessoal = DB::table('selecao_pessoals')
            ->join('cargos', 'selecao_pessoals.cargo_name_id', '=', 'cargos.id')
            ->select('selecao_pessoals.*', 'cargos.*', 'cargos.cargo_name as nome')
            ->where('unidade_id', $id)->where('status_selecao_pessoals',1)
            ->orderBy('ano', 'ASC')
            ->orderBy('cargos.cargo_name', 'ASC')
            ->get();
        if ($id == 1){
            $despesas = DB::table('despesa_hcp')->get();
            $nomeTabela = 'despesa_hcp';
        }
        if ($id == 2){
			$despesas = DB::table('desp_com_pessoal_hmr')->where('status_desp',1)->get();
			$nomeTabela = 'desp_com_pessoal_hmr';
		} else if ($id == 3){
			$despesas = DB::table('desp_com_pessoal_belo_jardim')->where('status_desp',1)->get();	
	        $nomeTabela = 'desp_com_pessoal_belo_jardim';
		} else if($id == 4){
			$despesas = DB::table('desp_com_pessoal_arcoverde')->where('status_desp',1)->get();	
		    $nomeTabela = 'desp_com_pessoal_arcoverde';
		} else if($id == 5){
			$despesas = DB::table('desp_com_pessoal_arruda')->where('status_desp',1)->get();	
		    $nomeTabela ='desp_com_pessoal_arruda';
		} else if($id == 6){
			$despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('status_desp',1)->get();	
		    $nomeTabela ='desp_com_pessoal_upaecaruaru';
		} else if($id == 7){
			$despesas = DB::table('desp_com_pessoal_hss')->where('status_desp',1)->get();	
			$nomeTabela ='desp_com_pessoal_hss';
		} else if($id == 8){
			$despesas = DB::table('desp_com_pessoal_hpr')->where('status_desp',1)->get();
			$nomeTabela ='desp_com_pessoal_hpr';
		} else if($id == 9){
		    $despesas = DB::table('desp_com_pessoal_igarassu')->where('status_desp',1)->get();
		    $nomeTabela ='desp_com_pessoal_igarassu';
		} else if($id == 10){
		    $despesas = DB::table('desp_com_pessoal_palmares')->where('status_desp',1)->get();
		    $nomeTabela ='desp_com_pessoal_palmares';
		}
		$despesaUpdates = DB::table('information_schema.TABLES')->select('TABLE_NAME','CREATE_TIME','UPDATE_TIME')->where('TABLE_NAME',$nomeTabela)->get();
            
        $servidores = ServidoresCedidosRH::where('unidade_id',$id)->orderBy('nome','ASC')->get();
        $regulamentosRh = RegulamentosRh::where('unidade_id',$id)->where('status_regula_rh',1)->get();
        
        $data = array();
        $data[] = $lastUpdatedRegulamento = '2017-08-31 00:00:00';   
        $data[] = $docSelectiveProcess->max('updated_at');
        
        $lastUpdates          = array();
        array_push($lastUpdates, 
        $selecaoPessoal      ->max('created_at'),
        $selecaoPessoal      ->max('updated_at'),
        $docSelectiveProcess ->max('created_at'),
        $docSelectiveProcess ->max('updated_at'),
        $despesaUpdates      ->max('created_at'),
        $despesaUpdates      ->max('updated_at'),
        $servidores          ->max('created_at'),
        $servidores          ->max('updated_at')
        );
        $lastUpdated         = max($lastUpdates);
        //Identificado ultima data de atualizacao da selecao pessoal
        $ultimoUpdate = DB::table('selecao_pessoals')
            ->select('updated_at')
            ->where('unidade_id', $id)
            ->orderBy('updated_at', 'DESC')
            ->limit(1)
            ->get();
        $ultimoCreate = DB::table('selecao_pessoals')
            ->select('created_at')
            ->where('unidade_id', $id)
            ->orderBy('created_at', 'DESC')
            ->limit(1)
            ->get();
        
        if(sizeof($ultimoUpdate) !== 0 || sizeof($ultimoCreate) !== 0){
            
            if ($ultimoUpdate[0]->updated_at > $ultimoCreate[0]->created_at) {
                $ultimaAtualiza = $ultimoUpdate[0]->updated_at;
            } else {
                $ultimaAtualiza = $ultimoCreate[0]->created_at;
            }
        }else{
            $ultimaAtualiza = date('Y-m-d');
        }
		$permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
		$justificativa = Justificativa::where('unidade_id',$id)->where('status',0)->where('tabela',1)->get();
		$justificativaRegulamentoRh = Justificativa::where('unidade_id',$id)->where('status',0)->where('tabela',4)->get();
        return view('transparencia.recursos-humanos', compact('unidade','unidadesMenu','selecaoPessoal','docSelectiveProcess','lastUpdatedRegulamento','lastUpdated','permissao_users','servidores','ultimaAtualiza','justificativa','justificativaRegulamentoRh','regulamentosRh'));
    }

    public function transparenciaBensPublicos($id)
    { 
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = $unidadesMenu->where('status_unidades', 1)->find($id); 
        $bens_pub     = BensPublicos::where('status_bens',1)->where('unidade_id', $id)->get();  
        $lastUpdated  = '2020-01-01 00:00:00';
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        
        return view('transparencia.bens-publicos', compact('bens_pub','unidade', 'unidadesMenu', 'lastUpdated', 'permissao_users'));
    }

    public function assistencialPdf($id, $year)
    {
        $unidadesMenu = Unidade::all();
        $unidade =$unidadesMenu->find($id);
        $assistencials = Assistencial::where('unidade_id', $id)->where('ano_ref', $year)->get();
        $pdf = PDF::loadView('transparencia.pdf.assistencial', compact('assistencials','unidade'));
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('assistencial.pdf');
    }
    
    public function visualizarOrdemCompra($id)
    { 
      $unidade      = Unidade::where('id',$id)->get();
      $processos    = Processos::where('unidade_id',$id)->paginate(20);
      $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
      return view('ordem_compra/ordem_compra_usuarios', compact('unidade','processos','processo_arq'));
    }

    public function procuraVisualizarOrdemCompra($unidade_id, Request $request)
    {    
      $input = $request->all();
      $unidade =  Unidade::where('id',$unidade_id)->get();
      $funcao = $input['funcao'];
      $funcao2 = $input['funcao2'];
      $text = $input['text'];
      $data = $input['data']; 
      if ($funcao2 == "1"){
        if($funcao == "1") {
            $processos = Processos::where('fornecedor','like','%'.$text.'%')->where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2" ){
            $processos = Processos::where('fornecedor','like','%'.$text.'%')->where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else {
            $processos = Processos::where('fornecedor','like','%'.$text.'%')->where('unidade_id',$unidade_id)->paginate(30);
        }
      } else if ($funcao2 == "2"){
        if($funcao == "1") {
            $processos = Processos::where('numeroSolicitacao','like','%'.$text.'%')->where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2") {
            $processos = Processos::where('numeroSolicitacao','like','%'.$text.'%')->where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else {
            $processos = Processos::where('numeroSolicitacao','like','%'.$text.'%')->where('unidade_id',$unidade_id)->paginate(30);
        }
      } else if ($funcao2 == "3"){ 
        if($funcao == "1") {
            $processos = Processos::where('produto','like','%'.$text.'%')->where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2") {
            $processos = Processos::where('produto','like','%'.$text.'%')->where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else {
            $processos = Processos::where('produto','like','%'.$text.'%')->where('unidade_id',$unidade_id)->paginate(30);
        }         
      } else {
        if($funcao == "1") {
            $processos = Processos::where('dataSolicitacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "2") {
            $processos = Processos::where('dataAutorizacao',$data)->where('unidade_id',$unidade_id)->paginate(30);	
        } else if($funcao == "0") {
            $processos = Processos::where('unidade_id',$unidade_id)->paginate(30); 		  
        }
      }
      $processo_arq = ProcessoArquivos::where('unidade_id', $unidade_id)->paginate(30);   
      return view('ordem_compra/ordem_compra_usuarios', compact('unidade','processos','processo_arq'));	
    }
    
    public function despesasUsuarioRH($id)
    {
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidades = $unidadesMenu;
        $unidade = Unidade::find($id);
        $ano  = 0;
        $mes  = 0;
        $tipo = 0;
        $teste = '';
        if ($id == 2){
			$despesas = DB::table('desp_com_pessoal_hmr')->where('status_desp',1)->get();
			$nomeTabela = 'desp_com_pessoal_hmr';
		} else if ($id == 3){
			$despesas = DB::table('desp_com_pessoal_belo_jardim')->where('status_desp',1)->get();	
	        $nomeTabela = 'desp_com_pessoal_belo_jardim';
		} else if($id == 4){
			$despesas = DB::table('desp_com_pessoal_arcoverde')->where('status_desp',1)->get();	
		    $nomeTabela = 'desp_com_pessoal_arcoverde';
		} else if($id == 5){
			$despesas = DB::table('desp_com_pessoal_arruda')->where('status_desp',1)->get();	
		    $nomeTabela ='desp_com_pessoal_arruda';
		} else if($id == 6){
			$despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('status_desp',1)->get();	
		    $nomeTabela ='desp_com_pessoal_upaecaruaru';
		} else if($id == 7){
			$despesas = DB::table('desp_com_pessoal_hss')->where('status_desp',1)->get();	
			$nomeTabela ='desp_com_pessoal_hss';
		} else if($id == 8){
			$despesas = DB::table('desp_com_pessoal_hpr')->where('status_desp',1)->get();
			$nomeTabela ='desp_com_pessoal_hpr';
		} else if($id == 9){
		    $despesas = DB::table('desp_com_pessoal_igarassu')->where('status_desp',1)->get();
		    $nomeTabela ='desp_com_pessoal_igarassu';
		} else if($id == 10){
		    $despesas = DB::table('desp_com_pessoal_palmares')->where('status_desp',1)->get();
		    $nomeTabela ='desp_com_pessoal_palmares';
		}
		$despesaUpdates = DB::table('information_schema.TABLES')->select('TABLE_NAME','CREATE_TIME','UPDATE_TIME')->where('TABLE_NAME',$nomeTabela)->get();
        $lastUpdates    = array();
        array_push($lastUpdates, 
        $despesaUpdates ->max('CREATE_TIME'),
        $despesaUpdates ->max('UPDATE_TIME')
        );
        $lastUpdated    = max($lastUpdates);
        return view('transparencia/rh/rh_despesas_exibe_usuario', compact('unidade', 'unidades', 'unidadesMenu', 'ano', 'mes', 'tipo', 'teste','lastUpdated'));
    }

    public function despesasUsuarioRHProcurar($id, Request $request)
    {
        $input = $request->all();
        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade = $unidadesMenu->where('status_unidades', 1)->find($id);
        $mes  = $input['mes'];
        $ano  = $input['ano'];
        $tipo = $input['tipo'];
        $teste = 'selected';
        if ($tipo == NULL) {
            $tipo = "";
        }
        if ($id == 2) {
            $despesas = DB::table('desp_com_pessoal_hmr')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 3) {
            $despesas = DB::table('desp_com_pessoal_belo_jardim')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 4) {
            $despesas = DB::table('desp_com_pessoal_arcoverde')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 5) {
            $despesas = DB::table('desp_com_pessoal_arruda')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 6) {
            $despesas = DB::table('desp_com_pessoal_upaecaruaru')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 7) {
            $despesas = DB::table('desp_com_pessoal_hss')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 8) {
            $despesas = DB::table('desp_com_pessoal_hpr')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        } else if ($id == 9) {
            $despesas = DB::table('desp_com_pessoal_igarassu')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        }else if($id == 10){
            $despesas = DB::table('desp_com_pessoal_palmares')->where('mes', $mes)->where('ano', $ano)->where('tipo', $tipo)->where('status_desp',1)->get();
        }
        return view('transparencia/rh/rh_despesas_exibe_usuario	', compact('unidade', 'despesas', 'unidadesMenu', 'ano', 'mes', 'tipo', 'teste'));
    }
    
    public function ocorrencia()
    {
        $ocorrencias = Ocorrencias::all();
        $setor = Setor::all();
        $tiposOcorrencias = TiposOcorrencias::all();
        $tiposIncidentes  = TipoIncidente::all(); 
        $problemaTiposIncidentes = ProblemaTipoIncidente::all(); 
        $processoTiposIncidentes = ProcessoTipoIncidente::all();
        return view('ocorrencias/novaOcorrencia', compact('setor', 'ocorrencias', 'tiposOcorrencias', 'tiposIncidentes', 'problemaTiposIncidentes', 'processoTiposIncidentes'));
    }

    public function storeOcorrencia(Request $request)
    {
        $input = $request->all(); 
        for ($a = 1; $a < 22; $a++) {
            if($input['problema_incidente'.$a] != 0) { $input['problema_incidente'] = $input['problema_incidente'.$a]; }
        }
        $tiposOcorrencias = TipoIncidente::where('id', $input['classificar_incidente'])->get();
        $input['classificar_incidente'] = $tiposOcorrencias[0]->nome;
        $validator = Validator::make($request->all(), [
			'data_ocorrencia'       => 'required|date',
			'data_relato'           => 'required|date',
			'processo'              => 'required|max:255',
			'origem'                => 'required|max:255',
			'unidade'               => 'required|max:255',
			'notificacao'           => 'required|max:255',
			'tipoocorrencia'        => 'required|max:255',
			'ocorrencia'            => 'required|max:255',
			'descricao_ocorrencia'  => 'required|max:800',
			'descricao_evento'      => 'required|max:1000',
			'acao_imediata'         => 'required|max:800',
			'data_acao_corretiva'   => 'required|max:255',
			'classificacao_ocorrencia' => 'required|max:255',
			'classificacao_dano'    => 'required|max:255',
			'classificar_incidente' => 'required|max:255',
			'processo_incidente'    => 'required|max:255'
			
		]);
        if ($validator->fails()) {
            $ocorrencias = Ocorrencias::all();
            $setor = Setor::all();
            $tiposOcorrencias = TiposOcorrencias::all();
            $tiposIncidentes  = TipoIncidente::all(); 
            $problemaTiposIncidentes = ProblemaTipoIncidente::all(); 
            $processoTiposIncidentes = ProcessoTipoIncidente::all();
			return view('ocorrencias/novaOcorrencia', compact('setor', 'ocorrencias', 'tiposOcorrencias','tiposIncidentes','problemaTiposIncidentes','processoTiposIncidentes'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
		    $oco = Ocorrencias::where('id',$input['ocorrencia'])->get();
		    $input['ocorrencia'] = $oco[0]->descricao;
            $OcorrenciasForm = OcorrenciasForm::create($input);
            $OcorrenciasForm = OcorrenciasForm::all();
            $validator = 'Ocorrencia enviada com Sucesso!';
            return redirect()->route('ocorrencia')
                ->withErrors($validator);
		}
    }

    public function transparenciaIntegridade($id)
    {
        $unidadesMenu = Unidade::all();
        $unidade      = $unidadesMenu->find($id);
        $integridade  = CertificadoIntegridade::where('status_integridade', 1)->get();
        $lastUpdated  = $integridade->max('updated_at');
        $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
        return view('transparencia.integridade', compact('unidade','unidadesMenu','integridade','lastUpdated','permissao_users'));
    }

    public function documentacoes($id_und){
        if (Auth::check()){
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
            $integridade  = CertificadoIntegridade::where('status_integridade', 1)->get();
            $lastUpdated  = $integridade->max('updated_at');
            $documentacoes = Documentacao::all();
            return view('transparencia.documentacoes', compact('unidade', 'unidadesMenu', 'permissao_users', 'lastUpdated', 'documentacoes'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }
}