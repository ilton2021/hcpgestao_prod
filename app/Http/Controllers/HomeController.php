<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\ProcessoArquivos;
use App\Models\Processos;
use App\Models\Cotacao;
use App\Models\LoggerUsers;
use App\Models\Contrato;
use App\Models\Aditivo;
use App\Models\DespesasPessoais;
use App\Models\RelatorioFinanceiro;
use App\Models\DemonstracaoContabel;
use App\Models\DemonstrativoFinanceiro;
use App\Models\Assistencial;
use App\Models\Repasse;
use App\Models\SelecaoPessoal;
use App\Models\PermissaoUsers;
use App\Models\TipoDocumento;
use App\Models\ContratosLayout;
use App\Http\Controllers\ContratacaoController;
use App\Http\Controllers\PermissaoUsersController;
use App\Imports\processoImport;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;
use ZipArchive;
use Excel;

class HomeController extends Controller
{
	protected $unidade;
      
    public function __construct(Unidade $unidade)
    {
        $this->unidade = $unidade;
    }

    public function index()
    {
      $unidades = Unidade::all();
      if(Auth::user()->funcao == 1 || Auth::user()->funcao == 0) {
        return view('home', compact('unidades'));
      } else {
        $unidades  = $this->unidade->all();
				$unidade   = Unidade::where('id', 1)->get();
        $validator = 'Você não tem essa Permissão!'; 
				return view('home_sistema', compact('unidades','unidade'))->withErrors($validator); 		
      }
    }

    public function homeCompras()
    {
      if(Auth::user()->funcao == 3 || Auth::user()->funcao == 0) {
        $unidades = Unidade::all();
        return view('home_compras', compact('unidades'));
      } else {
        $unidades  = $this->unidade->all();
				$unidade   = Unidade::where('id', 1)->get();
        $validator = 'Você não tem essa Permissão!'; 
				return view('home_sistema', compact('unidades','unidade'))->withErrors($validator); 		
      }
    }

    public function homeContratos()
    {
      if(Auth::user()->funcao == 3 || Auth::user()->funcao == 0) {
        $unidades = Unidade::all();
        return view('home_contratos', compact('unidades'));
      } else {
        $unidades  = $this->unidade->all();
				$unidade   = Unidade::where('id', 1)->get();
        $validator = 'Você não tem essa Permissão!'; 
				return view('home_sistema', compact('unidades','unidade'))->withErrors($validator); 		
      }
    }

    public function transparenciaContratos($id)
    {       
        $documentos = ContratosLayout::orderBy('created_at', 'DESC')->get();
        $tiposDocumentos = TipoDocumento::all();
        $unidades = Unidade::all();
        return view('home_contratos', compact('documentos', 'tiposDocumentos', 'unidades'));
    }

    public function homeContratosLayout($id)
    {       
        $documentos = ContratosLayout::orderBy('created_at', 'DESC')->get();
        $tiposDocumentos = TipoDocumento::all();
        $unidades = Unidade::all();
        $unidade  = Unidade::where('id', $id)->get();
        return view('transparencia.contratos_layout.home_layout', compact('documentos', 'tiposDocumentos', 'unidades', 'unidade'));
    }
	
	  public function transparenciaHome($id)
    {
      $unidadesMenu = Unidade::all();
      $unidades     = $unidadesMenu;
      $unidade      = Unidade::where('id', $id)->get(); 
      $lastUpdated  = $unidade->max('updated_at');
      return view('transparencia.institucional', compact('unidade','unidades','unidadesMenu','lastUpdated'));
    }

    public function transparenciaOrdemCompra($id)
    {
      $unidade      = Unidade::where('id',$id)->get();
      $processos    = Processos::where('unidade_id',$id)->paginate(20);
      $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
      return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));
    }

    public function transparenciaOrdemCompraNovoArquivo($unidade_id, Request $request)
    {
      $unidade = Unidade::where('id',$unidade_id)->get();
      return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'));
    }

    public function storeOrdemCompraNovoArquivo($unidade_id, Request $request)
    { 
      $input    = $request->all();
      $unidade  = Unidade::where('id',$unidade_id)->get();
      $nome     = $_FILES['file_path']['name']; 
      $extensao = pathinfo($nome, PATHINFO_EXTENSION);
      if($request->file('file_path') === NULL) {	
        $validator = 'Informe o arquivo da Ordem de Compra!';
        return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'))
             ->withErrors($validator)
             ->withInput(session()->flashInput($request->input()));
      } else {	
        if(($extensao === 'csv') || ($extensao === 'xls') || ($extensao === 'xlsx')) {
          $validator = Validator::make($request->all(), [
            'file_path' => 'required',
          ]);
          if ($validator->fails()) {
            $validator = 'o campo arquivo e obrigatorio!';
            return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'))
                  ->withErrors($validator)
                  ->withInput(session()->flashInput($request->input()));
          } else {
            \Excel::import(new processoImport($unidade_id), $request->file('file_path')); 
            $input['user_id'] = Auth::user()->id;
            $log = LoggerUsers::create($input);
            $processos = Processos::where('unidade_id', $unidade_id)->paginate(30);
            $processo_arq = ProcessoArquivos::where('unidade_id',$unidade_id)->get();
            return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));		
          }
        } else {
          $validator = 'So sao suportados arquivos tipo: .csv, .xls, .xlsx';
          return view('ordem_compra/ordem_compras_novo_planilha', compact('unidade'))
              ->withErrors($validator)
              ->withInput(session()->flashInput($request->input()));
        }
      }
    }    

    public function transparenciaOrdemCompraNovo($id)
    {
      $unidade = Unidade::where('id',$id)->get();
      $mes = date('m',strtotime('now')); 
      $ano = date('Y', strtotime('now'));
      $processos = Processos::whereMonth('created_at',$mes)->whereYear('created_at',$ano)
                               ->where('unidade_id',$id)->get();
      return view('ordem_compra/ordem_compras_novo', compact('unidade','processos'));
    }

    public function storeOrdemCompra($id, Request $request)
    {
      $input   = $request->all();
      $unidade = Unidade::where('id',$id)->get();
      $validator = Validator::make($request->all(), [
        'numeroSolicitacao'  => 'required|max:255',
        'dataSolicitacao'    => 'required|date',
        'numeroOC'           => 'required|max:255',
        'dataAutorizacao'    => 'required|date',
        'fornecedor'         => 'required|max:255',
        'cnpj'               => 'required|max:14',
        'produto'            => 'required|max:500',
        'qtdOrdemCompra'     => 'required|max:255',
        'totalValorOC'       => 'required|max:255',
        'classificacaoItem'  => 'required|max:255',
        'numeroNotaFiscal'   => 'required|max:255',
        'quantidadeRecebida' => 'required|max:255',
        'valorTotalRecebido' => 'required|max:255',
        'chaveAcesso'        => 'required|max:255',
        'codigoIBGE'         => 'required|max:255' 
      ]);
      if ($validator->fails()) {
        $mes = date('m',strtotime('now')); 
        $ano = date('Y', strtotime('now'));
        $processos = Processos::whereMonth('created_at',$mes)->whereYear('created_at',$ano)
                              ->where('unidade_id',$id)->get();
        $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
        return view('ordem_compra/ordem_compras_novo', compact('unidade','processos','processo_arq'))
              ->withErrors($validator)
						  ->withInput(session()->flashInput($request->input()));
      } else {
        $processos = Processos::create($input);
        $processos = Processos::all();
        $input['user_id'] = Auth::user()->id;
        $log = LoggerUsers::create($input);
        $mes = date('m',strtotime($processos[0]->created_at));
        $now = date('m',strtotime('now')); 
        $processos = Processos::whereMonth('created_at',$mes)->where('unidade_id',$id)->get();
        $validator = 'A Ordem de Compra(OC) foi cadastrada com sucesso!';
        $processo_arq = ProcessoArquivos::where('unidade_id',$id)->get();
        return view('ordem_compra/ordem_compras_novo', compact('unidade','processos','processo_arq'))
		 				 ->withErrors($validator)
						 ->withInput(session()->flashInput($request->input()));
      }
    }

    public function ordemCompraAlterar($unidade_id,$id, Request $request)
    {
      $unidade   = Unidade::where('id',$unidade_id)->get();
      $processos = Processos::where('id', $id)->get();
      return view('ordem_compra/ordem_compras_alterar', compact('unidade','processos'));
    }

    public function updateOrdemCompra($unidade_id, $id, Request $request)
    {  
      $input     = $request->all();
      $unidade   = Unidade::where('id',$unidade_id)->get();
      $processos = Processos::where('id',$id)->get();
      $validator = Validator::make($request->all(), [
        'numeroSolicitacao'  => 'required|max:255',
        'dataSolicitacao'    => 'required',
        'numeroOC'           => 'required|max:255',
        'dataAutorizacao'    => 'required',
        'fornecedor'         => 'required|max:255',
        'cnpj'               => 'required|max:14',
        'produto'            => 'required|max:500',
        'qtdOrdemCompra'     => 'required|max:255',
        'totalValorOC'       => 'required|max:255',
        'classificacaoItem'  => 'required|max:255',
        'numeroNotaFiscal'   => 'required|max:255',
        'quantidadeRecebida' => 'required|max:255',
        'valorTotalRecebido' => 'required|max:255',
        'chaveAcesso'        => 'required|max:255',
        'codigoIBGE'         => 'required|max:255' 
      ]); 
      if ($validator->fails()) {
        return view('ordem_compra/ordem_compras_alterar', compact('unidade','processos'))
		   				->withErrors($validator)
			  			->withInput(session()->flashInput($request->input()));
      } else { 
        $processos = Processos::find($id);
        $processos->update($input);
        $input['user_id'] = Auth::user()->id;
        $logs      = LoggerUsers::create($input);
        $processos = Processos::where('id',$id)->paginate(30);       
        $processo_arq = ProcessoArquivos::where('unidade_id',$unidade_id)->get(); 
        $validator = 'A Ordem de Compra(OC) foi alterada com sucesso!';
        return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'))
		  				->withErrors($validator)
			  			->withInput(session()->flashInput($request->input()));
      }
    }

    public function ordemCompraExcluir($unidade_id, $id , Request $request)
	  {
      $unidade   = Unidade::where('id',$unidade_id)->get();
      $processos = Processos::where('id', $id)->get();
      return view('ordem_compra/ordem_compras_excluir', compact('unidade','processos'));	
    }
      
    public function destroyOrdemCompra($unidade_id, $id, Request $request)
    { 
      $input = $request->all();
      Processos::find($id)->delete(); 
      $input['user_id'] = Auth::user()->id;
      $logs = LoggerUsers::create($input);
      $unidade = Unidade::where('id',$unidade_id)->get();
      $processos = Processos::where('unidade_id', $unidade_id)->paginate(30);
		  $input = $request->all();
      $validator = 'A Ordem de Compra(OC) foi excluída com sucesso!';
      $processo_arq = ProcessoArquivos::where('unidade_id',$unidade_id)->get(); 
      return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));	
    }
    
    public function procuraOrdemCompra($unidade_id, Request $request)
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
     	return view('ordem_compra/ordem_compras_cadastro', compact('unidade','processos','processo_arq'));	
	}

	public function addOrdemCompra($id)
	{
    $unidadesMenu = Unidade::all();
	  $unidades     = Unidade::all();
		$unidade      = Unidade::find($id);
    $validator    = 'Arquivo adicionado com Sucesso!';
		return view('transparencia/contratacao/cotacao_excel', compact('unidades','unidade'))
            ->withErrors($validator)
	      		->withInput(session()->flashInput($request->input()));	
	}

  public function storeArquivoOrdemCompra($id, $id_processo, Request $request)
	{
    $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
    $unidade = Unidade::where('id' , $id)->get();
    $processos = Processos::where('unidade_id', $id)->where('id', $id_processo)->get();
    $input = $request->all(); $a = 0;
    for($i=1; $i<=5; $i++){
      if(!empty($input['file_path_'.$i])) {
        $solicitacao = $input['numeroSolicitacao'];
        $nome = $_FILES['file_path_'.$i]['name'];                      
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        if($extensao === 'pdf') {
          $request->file('file_path_'.$i)->move('../public/storage/cotacoes/arquivos/'. $solicitacao. '/',$nome);	
          $input['file_path_'.$i] = 'cotacoes/arquivos/'.$solicitacao.'/'.$nome;
          $input['processo_id'] = $id_processo;
          $input['file_path'] = $nome;
          $input['title'] = $input['title'.$i];
          ProcessoArquivos::create($input);	
          $a += 1;
        } else{
          $validator = 'Só suporta arquivos do tipo PDF!';
          return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'))
               ->withErrors($validator)
               ->withInput(session()->flashInput($request->input()));
        }          
      }
    }
    if($a > 0){
      $input['user_id'] = Auth::user()->id;
      $logs = LoggerUsers::create($input);
      $lastUpdated = $logs->max('updated_at'); 
      $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
      $validator = 'Arquivo de Ordem de Compra, cadastrado com sucesso!';
      return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'))
              ->withErrors($validator)
              ->withInput(session()->flashInput($request->input()));		
    } else {
      $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
      $validator = 'Informe um Arquivo para o Cadastro!';
      return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));		
    }
  } 

  public function cadastroOrdemCompra($id_unidade)
  { 
    $unidades  = $unidadesMenu = Unidade::all();
    $unidade   = Unidade::find($id);
    $cotacoes  = Cotacao::where('unidade_id', $id_unidade)->get();
    $processos = Processos::where('unidade_id', $id_unidade)->paginate(50);
    $processo_arquivos = ProcessoArquivos::where('unidade_id', $id_unidade)->paginate(50); 
    return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidades','unidade','cotacoes','processos','processo_arquivos'));
  }
    
  public function arquivosOrdemCompra($id, $id_processo, Request $request)
  {
    $mes = date('m',strtotime('now')); 
    $processos = Processos::where('id', $id_processo)->get();
    $processo_arquivos = ProcessoArquivos::where('unidade_id',$id)->get();
    $unidade = Unidade::where('id',$id)->get();
  	return view('ordem_compra/ordem_compras_arquivos_novo', compact('unidade','processos','processo_arquivos'));
  }
        
  public function relatorios($id)
  {
    $validacao = permissaoUsersController::Permissao($id);
    $unidadesMenu = Unidade::all();
    $unidades  = $unidadesMenu; 
    $unidade   = Unidade::find($id);
    $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
    if($validacao == 'ok') {
      return view('transparencia/relatorios', compact('unidade','unidades','unidadesMenu','permissao_users'));
    } else {
      $validator = 'Você não tem Permissão!!';
      return view('home', compact('unidades','unidade','unidadesMenu'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));
    }
  }

  public function relatorioTotalContratos($id)
  {
    $validacao = permissaoUsersController::Permissao($id);
    $unidadesMenu = Unidade::all();
    $unidades  = $unidadesMenu; 
    $unidade   = Unidade::find($id);
    $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
    $contratos = Contrato::where('unidade_id',$id)->get();
    $qtdContratos = sizeof($contratos);
    $aditivos  = Aditivo::where('unidade_id',$id)->get();
    $qtdAditivos = sizeof($aditivos);
    if($validacao == 'ok') {
      return view('transparencia/relatorios/relatorio_total_contratos', compact('unidade','unidades','unidadesMenu','permissao_users','qtdContratos','qtdAditivos'));
    } else {
      $validator = 'Você não tem Permissão!!';
      return view('home', compact('unidades','unidade','unidadesMenu'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));
    }
  }

  public function relatorioPesqTotalContratos($id, Request $request)
  {
    $validacao       = permissaoUsersController::Permissao($id);
    $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
    $unidadesMenu    = Unidade::all();
    $unidades        = $unidadesMenu; 
    $unidade         = Unidade::find($id);
    $input           = $request->all();
    $idU             = $input['unidade_id'];
    $contratos = Contrato::where('unidade_id',$idU)->get();
    $qtdContratos = sizeof($contratos);
    $aditivos = Aditivo::where('unidade_id',$idU)->get();
    $qtdAditivos = sizeof($aditivos);
    if($validacao == 'ok') {
      return view('transparencia/relatorios/relatorio_total_contratos', compact('unidade','unidades','unidadesMenu','permissao_users','qtdContratos','qtdAditivos'));
    } else {
      $validator = 'Você não tem Permissão!!';
      return view('home', compact('unidades','unidade','unidadesMenu'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));
    }
  }

  public function relatorioDespesasUnidade($id)
  {
    $validacao = permissaoUsersController::Permissao($id);
    $unidadesMenu = Unidade::all();
    $unidades = $unidadesMenu; 
    $unidade  = Unidade::find($id);
    $permissao_users = PermissaoUsers::where('unidade_id', $id)->get();
    if($id == 2) {
      $despesas = DB::table('desp_com_pessoal_hmr')->get();
    } else if($id == 3){
      $despesas = DB::table('desp_com_pessoal_belo_jardim')->get();
    } else if($id == 4){
      $despesas = DB::table('desp_com_pessoal_arcoverde')->get();
    } else if($id == 5){
      $despesas = DB::table('desp_com_pessoal_arruda')->get();
    } else if($id == 6){
      $despesas = DB::table('desp_com_pessoal_upaecaruaru')->get();
    } else if($id == 7){
      $despesas = DB::table('desp_com_pessoal_hss')->get();
    } else if($id == 8){
      $despesas = DB::table('desp_com_pessoal_hpr')->get();
    } else if($id == 9){
      $despesas = DB::table('desp_com_pessoal_igarassu')->get();
    }
    $qtdDespesas = sizeof($despesas); $qtd = 0;
    $quantidades = 0;
    for($a = 1; $a < $qtdDespesas; $a++) {
      $quantidades += $despesas[$a]->Quant;
    }
    if($validacao == 'ok') {
      return view('transparencia/relatorios/relatorio_total_despesas', compact('unidade','unidades','unidadesMenu','permissao_users','qtdDespesas','despesas','quantidades','qtd'));
    } else {
      $validator = 'Você não tem Permissão!!';
      return view('home', compact('unidades','unidade','unidadesMenu'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));
    }
  }

  public function relatorioPesquisaDespesas($id, Request $request)
  {
    $input = $request->all(); 
    if(empty($input['ano'])) { $input['ano'] = ""; }
    if(empty($input['mes'])) { $input['mes'] = ""; }
    $ano = $input['ano']; 
    $mes = $input['mes'];
    if($id == 2) { $nome = 'hmr';
    } else if($id == 3){ $nome = 'belo_jardim';
    } else if($id == 4){ $nome = 'arcoverde';
    } else if($id == 5){ $nome = 'arruda';
    } else if($id == 6){ $nome = 'upaecaruaru';
    } else if($id == 7){ $nome = 'hss';
    } else if($id == 8){ $nome = 'hpr';
    } else if($id == 9){ $nome = 'igarassu'; }
    if($ano != "" && $mes != "") {
      $despesas = DB::table('desp_com_pessoal_'.$nome)->where('ano',$ano)->where('mes',$mes)->get();
    } else if($ano != "" && $mes == "") {
      $despesas = DB::table('desp_com_pessoal_'.$nome)->where('ano',$ano)->get();
    } else if($ano == "" && $mes != "") {
      $despesas = DB::table('desp_com_pessoal_'.$nome)->where('mes',$mes)->get();
    } else {
      $despesas = DB::table('desp_com_pessoal_'.$nome)->get();
    }
    $qtdDespesas = sizeof($despesas);
    $qtd = 0;
    for($a = 0; $a < $qtdDespesas; $a++){
      if($despesas[$a]->Nivel == "TOTAL GERAL"){
        $qtd = $despesas[$a]->Valor;
      }
    } 
    $unidadesMenu = Unidade::all();
    $unidades = $unidadesMenu; 
    $unidade = Unidade::find($id);
    return view('transparencia/relatorios/relatorio_total_despesas', compact('despesas','qtd','unidade','unidades','unidadesMenu'));
  }

  public function relatorioUltAtualizacoes($id)
  {
    $validacao = permissaoUsersController::Permissao($id);
    $unidadesMenu = Unidade::all();
    $unidades     = $unidadesMenu; 
    $unidade      = Unidade::find($id);
    $permissao_users  = PermissaoUsers::where('unidade_id', $id)->get();
    $relatorio_finan  = RelatorioFinanceiro::where('unidade_id',$id)->get();
    $anoRelFinanceiro = $relatorio_finan->max('ano');
    $demonst_contab   = DemonstracaoContabel::where('unidade_id',$id)->get();
    $anoDemContabel   = $demonst_contab->max('ano');
    $demonst_financ   = DemonstrativoFinanceiro::where('unidade_id',$id)->get();
    $anoDemonsFinanc  = $demonst_financ->max('ano');
    $demonst_financ   = DemonstrativoFinanceiro::where('unidade_id',$id)->where('ano',$anoDemonsFinanc)->get();
    $mesDemonsFinanc  = $demonst_financ->max('mes');
    $relatorio_ass    = Assistencial::where('unidade_id',$id)->get();
    $anoRelatAssist   = DB::table('assistencials')->where('unidade_id',$id)->max('ano_ref');
    $data             = DB::table('assistencials')->where('unidade_id',$id)->max('created_at');
    $relatorio_ass    = Assistencial::where('created_at',$data)->where('unidade_id',$id)->get();
    $qtdRelAss        = sizeof($relatorio_ass);
    if($qtdRelAss > 0) {
    if($relatorio_ass[0]->dezembro != ""){ $mes = 12; } 
    else if($relatorio_ass[0]->novembro != ""){ $mes = 11; }
    else if($relatorio_ass[0]->outubro != ""){ $mes = 10; }
    else if($relatorio_ass[0]->setembro != ""){ $mes = 9; }
    else if($relatorio_ass[0]->agosto != ""){ $mes = 8; }
    else if($relatorio_ass[0]->julho != ""){ $mes = 7; }
    else if($relatorio_ass[0]->junho != ""){ $mes = 6; }
    else if($relatorio_ass[0]->maio != ""){ $mes = 5; }
    else if($relatorio_ass[0]->abril != ""){ $mes = 4; }
    else if($relatorio_ass[0]->marco != ""){ $mes = 3; }
    else if($relatorio_ass[0]->fevereiro != ""){ $mes = 2; }
    else if($relatorio_ass[0]->janeiro != ""){ $mes = 1; }
    } else {
      $mes = "";
    } 
    $repasses    = DB::table('repasses')->where('unidade_id',$id)->get();
    $anoRepasses = $repasses->max('ano');  
    $idRepasses  = DB::table('repasses')->where('ano',$anoRepasses)->where('unidade_id',$id)->max('id');
    $mesRepasses = DB::table('repasses')->where('id',$idRepasses)->get('mes');
    $qtdRep = sizeof($repasses);
    if($qtdRep > 0) {
    if($mesRepasses[0]->mes == "dezembro"){ $mesRepasses = 12; }
    else if($mesRepasses[0]->mes == "novembro"){ $mesRepasses = 11; }
    else if($mesRepasses[0]->mes == "outubro"){ $mesRepasses = 10; }
    else if($mesRepasses[0]->mes == "setembro"){ $mesRepasses = 9; }
    else if($mesRepasses[0]->mes == "agosto"){ $mesRepasses = 8; }
    else if($mesRepasses[0]->mes == "julho"){ $mesRepasses = 7; }
    else if($mesRepasses[0]->mes == "junho"){ $mesRepasses = 6; }
    else if($mesRepasses[0]->mes == "maio"){ $mesRepasses = 5; }
    else if($mesRepasses[0]->mes == "abril"){ $mesRepasses = 4; }
    else if($mesRepasses[0]->mes == "marco"){ $mesRepasses = 3; }
    else if($mesRepasses[0]->mes == "fevereiro"){ $mesRepasses = 2; }
    else if($mesRepasses[0]->mes == "janeiro"){ $mesRepasses = 1; }
    } else {
      $mesRepasses = "";
    }
    $data          = DB::table('selecao_pessoals')->where('unidade_id',$id)->max('created_at');
    $selecaoPesso  = SelecaoPessoal::where('created_at',$data)->get();
    $anoSelPessoal = $selecaoPesso[0]->ano;
    if($validacao == 'ok') {
      return view('transparencia/relatorios/relatorio_total_ult_atualizacoes', compact('unidade','unidades','unidadesMenu','permissao_users','anoDemContabel','anoRelFinanceiro','anoDemonsFinanc','anoRepasses','mes','mesDemonsFinanc','anoRelatAssist','mesRepasses','anoSelPessoal'));
    } else {
      $validator = 'Você não tem Permissão!!';
      return view('home', compact('unidades','unidade','unidadesMenu'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));
    }
  }

  public function relatorioPesqUltAtual($id, Request $request)
  {
    $validacao    = permissaoUsersController::Permissao($id);
    $permissao_users  = PermissaoUsers::where('unidade_id', $id)->get();
    $input        = $request->all();
    $unidadesMenu = Unidade::all();
    $unidades     = $unidadesMenu; 
    $idU          = $input['unidade_id']; 
    $unidade      = Unidade::find($id);
    $relatorio_finan  = RelatorioFinanceiro::where('unidade_id',$idU)->get();
    $anoRelFinanceiro = $relatorio_finan->max('ano');
    $demonst_contab   = DemonstracaoContabel::where('unidade_id',$idU)->get();
    $anoDemContabel   = $demonst_contab->max('ano');
    $demonst_financ   = DemonstrativoFinanceiro::where('unidade_id',$idU)->get();
    $anoDemonsFinanc  = $demonst_financ->max('ano');
    $demonst_financ   = DemonstrativoFinanceiro::where('unidade_id',$idU)->where('ano',$anoDemonsFinanc)->get();
    $mesDemonsFinanc  = $demonst_financ->max('mes');
    $relatorio_ass    = Assistencial::where('unidade_id',$idU)->get();
    $anoRelatAssist   = DB::table('assistencials')->where('unidade_id',$idU)->max('ano_ref');
    $data             = DB::table('assistencials')->where('unidade_id',$idU)->max('created_at');
    $relatorio_ass    = Assistencial::where('created_at',$data)->where('unidade_id',$idU)->get();
    $qtdRelAss = sizeof($relatorio_ass);
    if($qtdRelAss > 0) {
    if($relatorio_ass[0]->dezembro != ""){ $mes = 12; } 
    else if($relatorio_ass[0]->novembro != ""){ $mes = 11; }
    else if($relatorio_ass[0]->outubro != ""){ $mes = 10; }
    else if($relatorio_ass[0]->setembro != ""){ $mes = 9; }
    else if($relatorio_ass[0]->agosto != ""){ $mes = 8; }
    else if($relatorio_ass[0]->julho != ""){ $mes = 7; }
    else if($relatorio_ass[0]->junho != ""){ $mes = 6; }
    else if($relatorio_ass[0]->maio != ""){ $mes = 5; }
    else if($relatorio_ass[0]->abril != ""){ $mes = 4; }
    else if($relatorio_ass[0]->marco != ""){ $mes = 3; }
    else if($relatorio_ass[0]->fevereiro != ""){ $mes = 2; }
    else if($relatorio_ass[0]->janeiro != ""){ $mes = 1; }
    } else {
      $mes = "";
    }
    $repasses    = DB::table('repasses')->where('unidade_id',$idU)->get();
    $anoRepasses = $repasses->max('ano');  
    $idRepasses  = DB::table('repasses')->where('ano',$anoRepasses)->where('unidade_id',$idU)->max('id');
    $mesRepasses = DB::table('repasses')->where('id',$idRepasses)->get('mes');
    $qtdRep = sizeof($repasses);
    if($qtdRep > 0) {
    if($mesRepasses[0]->mes == "dezembro"){ $mesRepasses = 12; }
    else if($mesRepasses[0]->mes == "novembro"){ $mesRepasses = 11; }
    else if($mesRepasses[0]->mes == "outubro"){ $mesRepasses = 10; }
    else if($mesRepasses[0]->mes == "setembro"){ $mesRepasses = 9; }
    else if($mesRepasses[0]->mes == "agosto"){ $mesRepasses = 8; }
    else if($mesRepasses[0]->mes == "julho"){ $mesRepasses = 7; }
    else if($mesRepasses[0]->mes == "junho"){ $mesRepasses = 6; }
    else if($mesRepasses[0]->mes == "maio"){ $mesRepasses = 5; }
    else if($mesRepasses[0]->mes == "abril"){ $mesRepasses = 4; }
    else if($mesRepasses[0]->mes == "marco"){ $mesRepasses = 3; }
    else if($mesRepasses[0]->mes == "fevereiro"){ $mesRepasses = 2; }
    else if($mesRepasses[0]->mes == "janeiro"){ $mesRepasses = 1; }
    } else {
      $mesRepasses = "";
    }
    $data          = DB::table('selecao_pessoals')->where('unidade_id',$idU)->max('created_at');
    $selecaoPesso  = SelecaoPessoal::where('created_at',$data)->get();
    $anoSelPessoal = $selecaoPesso[0]->ano;
    if($validacao == 'ok') {
      return view('transparencia/relatorios/relatorio_total_ult_atualizacoes', compact('unidade','unidades','unidadesMenu','permissao_users','anoDemContabel','anoRelFinanceiro','anoDemonsFinanc','anoRepasses','mes','mesDemonsFinanc','anoRelatAssist','mesRepasses','anoSelPessoal'));
    } else {
      $validator = 'Você não tem Permissão!!';
      return view('home', compact('unidades','unidade','unidadesMenu'))
           ->withErrors($validator)
           ->withInput(session()->flashInput($request->input()));
    }
  }
}