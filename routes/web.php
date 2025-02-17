<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('welcome');
Route::get('/rp', [App\Http\Controllers\IndexController::class, 'rp'])->name('rp');
Route::get('/rp2/{id}', [App\Http\Controllers\IndexController::class, 'rp2'])->name('rp2');
Route::get('/rp3/{id_u}/{id}', [App\Http\Controllers\IndexController::class, 'rp3'])->name('rp3');
//Ocorrencias
Route::get('/ocorrencia', [App\Http\Controllers\IndexController::class, 'ocorrencia'])->name('ocorrencia');

Route::post('/ocorrencia_enviar', [App\Http\Controllers\IndexController::class, 'storeOcorrencia'])->name('storeOcorrencia');
Route::get('/ocorrencia/login', [App\Http\Controllers\IndexController::class, 'loginOcorrencia'])->name('loginOcorrencia');
Route::post('/ocorrencia/login_submit', [App\Http\Controllers\IndexController::class, 'loginOcorrenciaSubmit'])->name('loginSubmitOcorrencia');
Route::get('/ocorrencia/loginReset', [App\Http\Controllers\IndexController::class, 'loginOcorrenciaReset'])->name('loginResetOcorrencia');
Route::post('/ocorrencia/loginReset_submit', [App\Http\Controllers\IndexController::class, 'loginOcorrenResetSubmit'])->name('loginOcorrenSubmitReset');

Route::prefix('transparencia')->group( function(){
	Route::get('/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaHome'])->name('transparenciaHome');
	Route::get('/Oss/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaHomeOss'])->name('transparenciaHomeOss');
	Route::get('associados/export', [App\Http\Controllers\IndexController::class, 'exportAssociados'])->name('exportAssociados');
    Route::get('conselhoadmin/export', [App\Http\Controllers\IndexController::class, 'exportConselhoAdm'])->name('exportConselhoAdm');
    Route::get('conselhofisc/export', [App\Http\Controllers\IndexController::class, 'exportConselhoFisc'])->name('exportConselhoFisc');
    Route::get('superintendente/export', [App\Http\Controllers\IndexController::class, 'exportSuperintendente'])->name('exportSuperintendente');
    Route::get('estatuto/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaEstatuto'])->name('transparenciaEstatuto');
    Route::get('documentos/{id}/{escolha}', [App\Http\Controllers\IndexController::class, 'transparenciaDocumento'])->name('transparenciaDocumento');
    Route::get('organizacional/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaOrganizacional'])->name('transparenciaOrganizacional');
    Route::get('organizacional/Oss/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaOrganizacionalOss'])->name('transparenciaOrganizacionalOss');
    Route::get('decreto/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaDecreto'])->name('transparenciaDecreto');
    Route::get('manual/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaManual'])->name('transparenciaManual');
    Route::get('pregao/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaPregao'])->name('transparenciaPregao');
    Route::get('contratos-gestao/{id}/{escolha}', [App\Http\Controllers\IndexController::class, 'transparenciaContratoGestao'])->name('transparenciaContratoGestao');
    Route::get('despesas/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaDespesas'])->name('transparenciaDespesas');
    Route::get('regulamento/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaRegulamento'])->name('transparenciaRegulamento');
    Route::get('assistencial/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaAssistencial'])->name('transparenciaAssistencial');
    Route::get('assistencial/export/{id}/{year}', [App\Http\Controllers\IndexController::class, 'exportAssistencialMensal'])->name('exportAssistencialMensal');
    Route::get('assistencial/export/{id}', [App\Http\Controllers\IndexController::class, 'exportAssistencialAnual'])->name('exportAssistencialAnual');
	Route::get('assistencial/{id}/visualizar', [App\Http\Controllers\IndexController::class, 'visualizarAssistencial'])->name('visualizarAssistencial');
    Route::get('institucional/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaInstitucionalPdf'])->name('transparenciaInstitucionalPdf');
    Route::get('competencia/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaCompetencia'])->name('transparenciaCompetencia');
	Route::get('relatorioGerencial/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaRelatorioGerencial'])->name('transparenciaRelatorioGerencial');
    Route::get('relatorio-financeiro/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaFinanReports'])->name('transparenciaFinanReports');
    Route::get('demonstrativo-financeiro/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaDemonstrative'])->name('transparenciaDemonstrative');
    Route::get('demonstrativo-contabel/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaAccountable'])->name('transparenciaAccountable');
	Route::get('membros/{id}/{escolha}', [App\Http\Controllers\IndexController::class, 'transparenciaMembros'])->name('transparenciaMembros');
    Route::get('repasses-recebidos/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaRepasses'])->name('transparenciaRepasses');
    Route::get('repasses/export/{id}/{year}', [App\Http\Controllers\IndexController::class, 'repassesExport'])->name('repassesExport');
	Route::get('repasses-recebidos/export/{id}/{year}', [App\Http\Controllers\IndexController::class, 'repassesSomExport'])->name('repassesSomExport');
    Route::get('contratacao/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaContratacao'])->name('transparenciaContratacao');
	Route::get('contratacao/{id}/pesquisarMesCotacao/{mes}/{ano}',[App\Http\Controllers\IndexController::class, 'pesquisarMesCotacao'])->name('pesquisarMesCotacao');
    Route::get('recursos-humanos/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaRecursosHumanos'])->name('transparenciaRecursosHumanos');
	Route::get('bens-publicos/{id_und}', [App\Http\Controllers\IndexController::class, 'transparenciaBensPublicos'])->name('transparenciaBensPublicos');
	Route::get('pdf/assistencial/{id}/{year}',[App\Http\Controllers\IndexController::class, 'assistencialPdf'])->name('assistencialPdf'); 
	Route::get('covenio/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaCovenio'])->name('transparenciaCovenio');
	Route::get('relcontasAtual/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaContasAtual'])->name('transparenciaContasAtual');
	Route::get('relmensalExecucao/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaRelMensalExecucao'])->name('transparenciaRelMensalExecucao');
	Route::get('relfinanceiroExercicio/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaMensalFinanceiroExercico'])->name('transparenciaMensalFinanceiroExercico');
	Route::get('resultadoProcessosCotacao/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaProcessoCotacao'])->name('transparenciaProcessoCotacao');
	Route::get('ouvidoria/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaOuvidoria'])->name('transparenciaOuvidoria');
	Route::get('ouvidoria/canal_denuncias/{id}',[App\Http\Controllers\IndexController::class, 'transparenciaOuvidoriaDenuncias'])->name('transparenciaOuvidoriaDenuncias');
	Route::get('home_compras/ordem_compra/ordemCompraVisualizar/{id}',[App\Http\Controllers\IndexController::class, 'visualizarOrdemCompra'])->name('visualizarOrdemCompra');
	Route::post('home_compras/ordem_compra/ordemCompraVisualizar/{id}',[App\Http\Controllers\IndexController::class, 'procuraVisualizarOrdemCompra'])->name('procuraVisualizarOrdemCompra');
	Route::get('recursos-humanos/{id}/selecaoPcadastro/despesasUsuarioRH',[App\Http\Controllers\IndexController::class, 'despesasUsuarioRH'])->name('despesasUsuarioRH');
	Route::post('recursos-humanos/{id}/selecaoPcadastro/despesasRH',[App\Http\Controllers\IndexController::class, 'despesasUsuarioRHProcurar'])->name('despesasUsuarioRHProcurar');
	Route::get('certificado_integridade/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaIntegridade'])->name('transparenciaIntegridade');
	Route::get('documentacoes/{id_und}', [App\http\Controllers\IndexController::class, 'documentacoes'])->name('documentacoes');

	Route::get('cipa/cipa_index',[App\Http\Controllers\CipaController::class, 'transparenciaCipa'])->name('transparenciaCipa');
	Route::get('cipa/cipa_cadastro',[App\Http\Controllers\CipaController::class, 'transparenciaCipaCadastro'])->name('transparenciaCipaCadastro');
	Route::post('cipa/cipa_cadastro',[App\Http\Controllers\CipaController::class, 'storeCipaCadastro'])->name('storeCipaCadastro');	
});

Auth::routes();

Route::get('auth/login',[App\Http\Controllers\UserController::class, 'telaLogin'])->name('telaLogin');
Route::get('auth/login/reset',[App\Http\Controllers\UserController::class, 'telaEmail'])->name('telaEmail');
Route::get('auth/passwords/email', [App\Http\Controllers\UserController::class, 'telaEmail'])->name('telaEmail');
Route::post('auth/login', [App\Http\Controllers\UserController::class, 'Login'])->name('Login');
Route::get('auth/login/emailreset', [App\Http\Controllers\UserController::class, 'emailReset'])->name('emailReset');
Route::post('auth/login/emailreset',[App\Http\Controllers\UserController::class, 'emailReset'])->name('emailReset');
Route::get('auth/passwords/reset', [App\Http\Controllers\UserController::class, 'telaReset'])->name('telaReset');
Route::post('auth/passwords/reset', [App\Http\Controllers\UserController::class, 'resetarSenha'])->name('resetarSenha');

Route::middleware(['auth'])->group( function() {

	Route::get('home_contratos', [App\Http\Controllers\HomeController::class, 'homeContratos'])->name('homeContratos');
	Route::get('cipa/cipa_lista',[App\Http\Controllers\CipaController::class, 'transparenciaCipaLista'])->name('transparenciaCipaLista');
	
    //Ordem de Compra
	Route::get('home_compras', [App\Http\Controllers\HomeController::class, 'homeCompras'])->name('homeCompras');
	Route::get('home_compras/ordem_compra/{id}', [App\Http\Controllers\HomeController::class, 'transparenciaOrdemCompra'])->name('transparenciaOrdemCompra');
	Route::post('home_compras/ordem_compra/{id}', [App\Http\Controllers\HomeController::class, 'procuraOrdemCompra'])->name('procuraOrdemCompra');
	Route::get('home_compras/ordem_compra/novo/{id}/arquivo', [App\Http\Controllers\HomeController::class, 'transparenciaOrdemCompraNovoArquivo'])->name('transparenciaOrdemCompraNovoArquivo');
	Route::post('home_compras/ordem_compra/novo/{id}/arquivo', [App\Http\Controllers\HomeController::class, 'storeOrdemCompraNovoArquivo'])->name('storeOrdemCompraNovoArquivo');
	Route::get('home_compras/ordem_compra/novo/{id}', [App\Http\Controllers\HomeController::class, 'transparenciaOrdemCompraNovo'])->name('transparenciaOrdemCompraNovo');
	Route::get('home_compras/ordem_compra/alterar/ordemCompraAlterar/{unidade_id}/{id}', [App\Http\Controllers\HomeController::class, 'ordemCompraAlterar'])->name('ordemCompraAlterar');
	Route::get('home_compras/ordem_compra/excluir/ordemCompraExcluir/{unidade_id}/{id}', [App\Http\Controllers\HomeController::class, 'ordemCompraExcluir'])->name('ordemCompraExcluir');
	Route::post('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/{id_processo}', [App\Http\Controllers\HomeController::class, 'storeArquivoOrdemCompra'])->name('storeArquivoOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/addOrdemCompra', [App\Http\Controllers\HomeController::class, 'addOrdemCompra'])->name('addOrdemCompra');
	Route::post('home_compras/ordem_compra/{id}/cadastcadastroArquivosOrdemCompraroCotacoes/addOrdemCompra', [App\Http\Controllers\HomeController::class, 'storeExcelOrdemCompra'])->name('storeExcelOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/addOrdemCompra', [App\Http\Controllers\HomeController::class, 'addOrdemCompra'])->name('addOrdemCompra');
	Route::get('home_compras/ordem_compra/{id}/cadastroArquivosOrdemCompra/{id_processo}', [App\Http\Controllers\HomeController::class, 'arquivosOrdemCompra'])->name('arquivosOrdemCompra');
	Route::post('home_compras/ordem_compra/novo/{id}', [App\Http\Controllers\HomeController::class, 'storeOrdemCompra'])->name('storeOrdemCompra');
	Route::post('home_compras/ordem_compra/alterar/ordemCompraAlterar/{unidade_id}/{id}', [App\Http\Controllers\HomeController::class, 'updateOrdemCompra'])->name('updateOrdemCompra');
	Route::post('home_compras/ordem_compra/excluir/ordemCompraExcluir/{unidade_id}/{id}', [App\Http\Controllers\HomeController::class, 'destroyOrdemCompra'])->name('destroyOrdemCompra');
	
	//Contratação de serviços
	Route::get('contracaoServicos/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'paginaContratacaoServicos'])->name('paginaContratacaoServicos');
	Route::post('contracaoServicos/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'paginaContratacaoServicos'])->name('paginaContratacaoServicos');
	Route::get('contracaoServicos/nova/{id_und}', [App\Http\Controllers\ContratacaoServicosController::class, 'novaContratacaoServicos'])->name('novaContratacaoServicos');
	Route::post('contracaoServicos/nova/{id_und}', [App\Http\Controllers\ContratacaoServicosController::class, 'novaContratacaoServicos'])->name('novaContratacaoServicos');
    Route::post('contracaoServicos/cadastro/{id_und}', [App\Http\Controllers\ContratacaoServicosController::class, 'salvarContratacaoServicos'])->name('salvarContratacaoServicos');
	Route::get('contracaoServicos/pesquisa/{id_und}', [App\Http\Controllers\ContratacaoServicosController::class, 'pesquisarContratacao'])->name('pesquisarContratacao');
	Route::post('contracaoServicos/pesquisa/{id_und}', [App\Http\Controllers\ContratacaoServicosController::class, 'pesquisarContratacao'])->name('pesquisarContratacao');
	Route::get('contracaoServicos/paginaexcluir/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pagExcluirContratacao'])->name('pagExcluirContratacao');
	Route::get('contracaoServicos/confirmexcluir/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirContratacao'])->name('excluirContratacao');
	Route::get('contracaoServicos/excEspContr/{idContr}/{idEsp}',[App\Http\Controllers\ContratacaoServicosController::class, 'exclEspeContratacao'])->name('exclEspeContratacao');
	Route::get('contracaoServicos/paginaAlterar/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pagAlterarContratacao'])->name('pagAlterarContratacao');
	Route::post('contracaoServicos/confirAlterar/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'alterarContratacao'])->name('alterarContratacao');
	Route::get('contracaoServicos/exclArqContr/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirArqContratacao'])->name('excluirArqContratacao');
	Route::post('contracaoServicos/exclArqContr/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirArqContratacao'])->name('excluirArqContratacao');
	Route::get('contracaoServicos/pagProrrContr/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pagProrrContratacao'])->name('pagProrrContratacao');
	Route::get('contracaoServicos/excProrrContr/{id}/{idCE}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirErrataContratacao'])->name('excluirErrataContratacao');
	Route::post('contracaoServicos/prorrContr/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'prorrContratacao'])->name('prorrContratacao');
	Route::get('contracaoServicos/exclArqErratContr/{id}/',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirArqErratContratacao'])->name('excluirArqErratContratacao');
	Route::post('contracaoServicos/exclArqErratContr/{id}/',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirArqErratContratacao'])->name('excluirArqErratContratacao');
	
	Route::get('especialidade/cadastro/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'paginaEspecialidade'])->name('paginaEspecialidade');
	Route::post('especialidade/cadastro/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'paginaEspecialidade'])->name('paginaEspecialidade');
	Route::get('especialidade/nova/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'novaEspecialidade'])->name('novaEspecialidade');
	Route::post('especialidade/nova/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'novaEspecialidade'])->name('novaEspecialidade');
	Route::post('especialidade/cadastro/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'salvarEspecialidade'])->name('salvarEspecialidade');
	Route::get('especialidade/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pesquisarEspecialidade'])->name('pesquisarEspecialidade');
	Route::post('especialidade/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pesquisarEspecialidade'])->name('pesquisarEspecialidade');
	Route::get('especialidade/paginaExclusao/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pagExcluirEspecialidade'])->name('pagExcluirEspecialidade');
	Route::get('especialidade/confirmarExclusao/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'excluirEspecialidade'])->name('excluirEspecialidade');
	Route::get('especialidade/paginaAlterar/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'pagAlterarEspecialidade'])->name('pagAlterarEspecialidade');
	Route::post('especialidade/confirmarAlterar/{id}/{id_und}',[App\Http\Controllers\ContratacaoServicosController::class, 'alterarEspecialidade'])->name('alterarEspecialidade');
	//Ocorrencias - Qualidade
	Route::get('/ocorrencias', [App\Http\Controllers\OcorrenciaController::class, 'index'])->name('indexOcorrencia');
	Route::get('/ocorrencias/show/{id}', [App\Http\Controllers\OcorrenciaController::class, 'show'])->name('showOcorrencia');

	Route::get('/cadastro_documentos', [App\Http\Controllers\DocumentosController::class, 'cadastroDocumentalUnidade'])->name('cadastroDocumentalUnidade');
	Route::get('/cadastro_documentos/{id}', [App\Http\Controllers\DocumentosController::class, 'cadastroDocumentalLista'])->name('cadastroDocumentalLista');
	Route::get('/cadastro_documentos/{id}/pesquisa', [App\Http\Controllers\DocumentosController::class, 'pesquisaDocumentos'])->name('pesquisaDocumentos');
	Route::post('/cadastro_documentos/{id}/pesquisa', [App\Http\Controllers\DocumentosController::class, 'pesquisaDocumentos'])->name('pesquisaDocumentos');
	Route::get('/cadastro_documentos/novo/{id}', [App\Http\Controllers\DocumentosController::class, 'cadastroDocumental'])->name('cadastroDocumental');
	Route::post('/cadastro_documentos/novo/{id}', [App\Http\Controllers\DocumentosController::class, 'storeDOC'])->name('storeDOC');
	Route::get('/cadastro_documentos/alterar/{id}/{id_doc}', [App\Http\Controllers\DocumentosController::class, 'cadastroDocumentalAlterar'])->name('cadastroDocumentalAlterar');
	Route::post('/cadastro_documentos/alterar/{id}/{id_doc}', [App\Http\Controllers\DocumentosController::class, 'updateDOC'])->name('updateDOC');
	Route::get('cadastro_documentos/alterarStatus/{id_und}/{id_doc}/{id}', [App\Http\Controllers\DocumentosController::class, 'alterarStatus'])->name('alterarStatus');
	Route::post('cadastro_documentos/alterarStatus/{id_und}/{id_doc}/{id}', [App\Http\Controllers\DocumentosController::class, 'updateDocStatus'])->name('updateDocStatus');

	Route::prefix('home')->group( function(){
		Route::get('', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
		Route::get('/{id}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');	
		
		//Permissao
		Route::get('permissao/{id}', [App\Http\Controllers\PermissaoController::class, 'cadastroPermissao'])->name('cadastroPermissao');
		Route::get('permissao/{id}/permissaoNovo', [App\Http\Controllers\PermissaoController::class, 'permissaoNovo'])->name('permissaoNovo');
		Route::get('permissao/{id}/permissaoUsuarioNovo', [App\Http\Controllers\PermissaoController::class, 'permissaoUsuarioNovo'])->name('permissaoUsuarioNovo');
		
		Route::get('permissao/{id}/permissaoSelecioAlterar/{id_usuario}', [App\Http\Controllers\PermissaoController::class, 'permissaoAlterar'])->name('permissaoAlterar');
		Route::get('permissao/{id}/permissaoSelecionadaAlterar/{id_usuario}/{permissao_id}', [App\Http\Controllers\PermissaoController::class, 'permissaoSelecionadaAlterar'])->name('permissaoSelecionadaAlterar');
		Route::post('permissao/{id}/permissaoSelecionadaAlterar/{id_usuario}/{permissao_id}',[App\Http\Controllers\PermissaoController::class, 'updatePermissao'])->name('updatePermissao');

		Route::get('permissao/{id}/permissaoExcluir/{id_usuario}', [App\Http\Controllers\PermissaoController::class, 'permissaoExcluir'])->name('permissaoExcluir');
		Route::post('permissao/{id}/permissaoExcluir/{permissao_id}/{usuario_id}', [App\Http\Controllers\PermissaoController::class, 'deletePermissao'])->name('deletePermissao');
		Route::post('permissao/{id}/permissaoExcluir/{usuario_id}', [App\Http\Controllers\PermissaoController::class, 'deletePermissoesAll'])->name('deletePermissoesAll');
		////
		
		//Institucional
		Route::get('institucionalCadastro/{id}', [App\Http\Controllers\InstitucionalController::class, 'institucionalCadastro'])->name('institucionalCadastro');
		Route::get('institucionalCadastro/{id}/institucionalNovo',[App\Http\Controllers\InstitucionalController::class, 'institucionalNovo'])->name('institucionalNovo');
		Route::get('institucionalCadastro/institucionalAlterar/{id}',[App\Http\Controllers\InstitucionalController::class, 'institucionalAlterar'])->name('institucionalAlterar');
		Route::get('institucionalCadastro/institucionalExcluir/{id}',[App\Http\Controllers\InstitucionalController::class, 'institucionalExcluir'])->name('institucionalExcluir');
		Route::post('institucionalCadastro/institucionalAlterar/{id}',[App\Http\Controllers\InstitucionalController::class, 'update'])->name('update');
		Route::post('institucionalCadastro/institucionalExcluir/{id}',[App\Http\Controllers\InstitucionalController::class, 'destroy'])->name('destroy');

		//Organizacional
		Route::get('organizacionalCadastro/{id}', [App\Http\Controllers\OrganizationalController::class, 'cadastroOR'])->name('cadastroOR');
		Route::get('organizacionalNovo/{id}', [App\Http\Controllers\OrganizationalController::class, 'novoOR'])->name('novoOR');
		Route::post('organizacionalNovo/{id}', [App\Http\Controllers\OrganizationalController::class, 'storeOR'])->name('storeOR');
		Route::get('organizacionalAlterar/{id_item}/unidade/{id_unidade}', [App\Http\Controllers\OrganizationalController::class, 'alterarOR'])->name('alterarOR');
		Route::post('organizacionalAlterar/{id_item}/unidade/{id_unidade}', [App\Http\Controllers\OrganizationalController::class, 'updateOR'])->name('updateOR');
		Route::get('organizacionalExcluir/{id_item}/unidade/{id_unidade}', [App\Http\Controllers\OrganizationalController::class, 'excluirOR'])->name('excluirOR');
		Route::post('organizacionalExcluir/{id_item}/unidade/{id_unidade}', [App\Http\Controllers\OrganizationalController::class, 'destroyOR'])->name('destroyOR');
		Route::get('organizacionalInativar/{id_item}/unidade/{id_unidade}', [App\Http\Controllers\OrganizationalController::class, 'telaInativarOR'])->name('telaInativarOR');
		Route::post('organizacionalInativar/{id_item}/unidade/{id_unidade}', [App\Http\Controllers\OrganizationalController::class, 'inativarOR'])->name('inativarOR');
		////
	
		//RegimentoInterno
		Route::get('regimento/{id}', [App\Http\Controllers\RegimentoInternoController::class, 'cadastroRE'])->name('cadastroRE');
		Route::get('regimento/{id}/regimentoNovo', [App\Http\Controllers\RegimentoInternoController::class, 'novoRE'])->name('novoRE');
		Route::post('regimento/{id}/regimentoNovo', [App\Http\Controllers\RegimentoInternoController::class, 'storeRE'])->name('storeRE');
		Route::get('regimento/{id}/regimentoExcluir/{id_escolha}', [App\Http\Controllers\RegimentoInternoController::class, 'excluirRE'])->name('excluirRE');
		Route::post('regimento/{id}/regimentoExcluir/{id_escolha}', [App\Http\Controllers\RegimentoInternoController::class, 'destroyRE'])->name('destroyRE');
		Route::get('regimento/{id}/regimentoAlterar/{id_escolha}', [App\Http\Controllers\RegimentoInternoController::class, 'alterarRE'])->name('alterarRE');
		Route::post('regimento/{id}/regimentoAlterar/{id_escolha}', [App\Http\Controllers\RegimentoInternoController::class, 'updateRE'])->name('updateRE');
		Route::get('regimento/{id}/regimentoInativar/{id_escolha}', [App\Http\Controllers\RegimentoInternoController::class, 'telaInativarRE'])->name('telaInativarRE');
		Route::post('regimento/{id}/regimentoInativar/{id_escolha}', [App\Http\Controllers\RegimentoInternoController::class, 'inativarRE'])->name('inativarRE');
		////

		//Competências
		Route::get('competencia/{id_unidade}/competenciaListar', [App\Http\Controllers\CompetenciaController::class, 'listarCP'])->name('listarCP');
		Route::get('competencia/{id_unidade}/competenciaNovo', [App\Http\Controllers\CompetenciaController::class, 'novoCP'])->name('novoCP');
		Route::post('competencia/{id_unidade}/competenciaNovo', [App\Http\Controllers\CompetenciaController::class, 'storeCP'])->name('storeCP');
		Route::get('competencia/{id_unidade}/competenciaCadastro/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'cadastroCP'])->name('cadastroCP');
		Route::get('competencia/{id_unidade}/competenciaAlterar/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'alterarCP'])->name('alterarCP');
		Route::post('/competencia/{id_unidade}/competenciaAlterar/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'updateCP'])->name('updateCP');
		Route::get('competencia/{id_unidade}/competenciaExcluir/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'excluirCP'])->name('excluirCP');
		Route::post('/competencia/{id_unidade}/competenciaExcluir/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'destroyCP'])->name('destroyCP');
		Route::get('competencia/{id_unidade}/competenciaInativar/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'telaInativarCP'])->name('telaInativarCP');
		Route::post('/competencia/{id_unidade}/competenciaInativar/{id_item}', [App\Http\Controllers\CompetenciaController::class, 'inativarCP'])->name('inativarCP');
		///
		
		//Organograma
		Route::get('organograma/{id}', [App\Http\Controllers\OrganizationalController::class, 'organograma'])->name('organograma');
		Route::get('organograma/{id}/organogramaNovo', [App\Http\Controllers\OrganizationalController::class, 'novoOG'])->name('novoOG');
		Route::post('organograma/{id}/organogramaNovo', [App\Http\Controllers\OrganizationalController::class, 'storeOG'])->name('storeOG');
		Route::get('organograma/{id}/organogramaExcluir', [App\Http\Controllers\OrganizationalController::class, 'excluirOG'])->name('excluirOG');
		Route::post('organograma/{id}/organogramaExcluir', [App\Http\Controllers\OrganizationalController::class, 'destroyOG'])->name('destroyOG');
		Route::get('organograma/{id}/organogramaInativar', [App\Http\Controllers\OrganizationalController::class, 'telaInativarOG'])->name('telaInativarOG');
		Route::post('organograma/{id}/organogramaInativar', [App\Http\Controllers\OrganizationalController::class, 'inativarOG'])->name('inativarOG');
		////
		
		//Associados:	
		Route::get('membros/{id}/Associados/associadoNovo', [App\Http\Controllers\AssociadoController::class, 'novoAS'])->name('novoAS');
		Route::post('membros/{id_unidade}/Associados/associadoNovo', [App\Http\Controllers\AssociadoController::class, 'storeAS'])->name('storeAS');
		Route::get('membros/{id}/Associados/listarAssociado', [App\Http\Controllers\AssociadoController::class, 'listarAS'])->name('listarAS');
		Route::get('membros/{id_unidade}/Associados/associadoAlterar/{id_associado}', [App\Http\Controllers\AssociadoController::class, 'alterarAS'])->name('alterarAS');
		Route::post('membros/{id_unidade}/Associados/associadoAlterar/{id_associado}', [App\Http\Controllers\AssociadoController::class, 'updateAS'])->name('updateAS');
		Route::get('membros/{id}/Associados/associadoExcluir/{id_associado}', [App\Http\Controllers\AssociadoController::class, 'excluirAS'])->name('excluirAS');
		Route::post('membros/{id_unidade}/Associados/associadoExcluir/{id_associado}', [App\Http\Controllers\AssociadoController::class, 'destroyAS'])->name('destroyAS');
		Route::get('membros/{id}/Associados/associadoInativar/{id_associado}', [App\Http\Controllers\AssociadoController::class, 'telaInativarAS'])->name('telaInativarAS');
		Route::post('membros/{id_unidade}/Associados/associadoInativar/{id_associado}', [App\Http\Controllers\AssociadoController::class, 'inativarAS'])->name('inativarAS');
		////
	
		//ConselhoAdm
		Route::get('membros/{id}/Associados/listarConselhoAdm', [App\Http\Controllers\ConselhoAdmController::class, 'listarCA'])->name('listarCA');
		Route::get('membros/{id}/Associados/conselhoAdmNovo', [App\Http\Controllers\ConselhoAdmController::class, 'novoCA'])->name('novoCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmNovo', [App\Http\Controllers\ConselhoAdmController::class, 'storeCA'])->name('storeCA');
		Route::get('membros/{id_unidade}/Associados/conselhoAdmAlterar/{id_associado}', [App\Http\Controllers\ConselhoAdmController::class, 'alterarCA'])->name('alterarCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmAlterar/{id_associado}', [App\Http\Controllers\ConselhoAdmController::class, 'updateCA'])->name('updateCA');
		Route::get('membros/{id}/Associados/conselhoAdmExcluir/{id_associado}', [App\Http\Controllers\ConselhoAdmController::class, 'excluirCA'])->name('excluirCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmExcluir/{id_associado}', [App\Http\Controllers\ConselhoAdmController::class, 'destroyCA'])->name('destroyCA');
		Route::get('membros/{id}/Associados/conselhoAdmInativar/{id_associado}', [App\Http\Controllers\ConselhoAdmController::class, 'telaInativarCA'])->name('telaInativarCA');
		Route::post('membros/{id_unidade}/Associados/conselhoAdmInativar/{id_associado}', [App\Http\Controllers\ConselhoAdmController::class, 'inativarCA'])->name('inativarCA');
		////

		//ConselhoFisc
		Route::get('membros/{id}/Associados/listarConselhoFisc', [App\Http\Controllers\ConselhoFiscController::class, 'listarCF'])->name('listarCF');
		Route::get('membros/{id}/Associados/conselhoFiscNovo', [App\Http\Controllers\ConselhoFiscController::class, 'novoCF'])->name('novoCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscNovo', [App\Http\Controllers\ConselhoFiscController::class, 'storeCF'])->name('storeCF');
		Route::get('membros/{id_unidade}/Associados/conselhoFiscAlterar/{id_associado}', [App\Http\Controllers\ConselhoFiscController::class, 'alterarCF'])->name('alterarCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscAlterar/{id_associado}', [App\Http\Controllers\ConselhoFiscController::class, 'updateCF'])->name('updateCF');
		Route::get('membros/{id}/Associados/conselhoFiscExcluir/{id_associado}', [App\Http\Controllers\ConselhoFiscController::class, 'excluirCF'])->name('excluirCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscExcluir/{id_associado}', [App\Http\Controllers\ConselhoFiscController::class, 'destroyCF'])->name('destroyCF');
		Route::get('membros/{id}/Associados/conselhoFiscInativar/{id_associado}', [App\Http\Controllers\ConselhoFiscController::class, 'telaInativarCF'])->name('telaInativarCF');
		Route::post('membros/{id_unidade}/Associados/conselhoFiscInativar/{id_associado}', [App\Http\Controllers\ConselhoFiscController::class, 'inativarCF'])->name('inativarCF');
		////
		
		//Superintendente
		Route::get('membros/{id}/Superentendentes/listarSuper', [App\Http\Controllers\SuperintendentesController::class, 'listarSUP'])->name('listarSUP');
		Route::get('membros/{id}/Superentendentes/superNovo', [App\Http\Controllers\SuperintendentesController::class, 'novoSUP'])->name('novoSUP');
		Route::post('membros/{id_unidade}/Superentendentes/superNovo', [App\Http\Controllers\SuperintendentesController::class, 'storeSUP'])->name('storeSUP');
		Route::get('membros/{id_unidade}/Superentendentes/superAlterar/{id_super}', [App\Http\Controllers\SuperintendentesController::class, 'alterarSUP'])->name('alterarSUP');
		Route::post('membros/{id_unidade}/Superentendentes/superAlterar/{id_super}', [App\Http\Controllers\SuperintendentesController::class, 'updateSUP'])->name('updateSUP');
		Route::get('membros/{id}/Superentendentes/superExcluir/{id_super}', [App\Http\Controllers\SuperintendentesController::class, 'excluirSUP'])->name('excluirSUP');
		Route::post('membros/{id_unidade}/Superentendentes/superExcluir/{id_super}', [App\Http\Controllers\SuperintendentesController::class, 'destroySUP'])->name('destroySUP');
		Route::get('membros/{id}/Superentendentes/superInativar/{id_super}', [App\Http\Controllers\SuperintendentesController::class, 'telaInativarSUP'])->name('telaInativarSUP');
		Route::post('membros/{id_unidade}/Superentendentes/superInativar/{id_super}', [App\Http\Controllers\SuperintendentesController::class, 'inativarSUP'])->name('inativarSUP');
		////
		
		//ContratodeGestão
		Route::get('contratos-gestao/{id_unidade}/contratoCadastro', [App\Http\Controllers\ContratoController::class, 'cadastroCG'])->name('cadastroCG');
		Route::get('contratos-gestao/{id_unidade}/contratoNovo', [App\Http\Controllers\ContratoController::class, 'novoCG'])->name('novoCG');
		Route::post('contratos-gestao/{id_unidade}/contratoNovo', [App\Http\Controllers\ContratoController::class, 'storeCG'])->name('storeCG');
		Route::get('contratos-gestao/{id_unidade}/contratoAlterar/{escolha}', [App\Http\Controllers\ContratoController::class, 'alterarCG'])->name('alterarCG');
		Route::post('contratos-gestao/{id_unidade}/contratoAlterar/{escolha}', [App\Http\Controllers\ContratoController::class, 'updateCG'])->name('updateCG');
		Route::get('contratos-gestao/{id_unidade}/contratoExcluir/{escolha}', [App\Http\Controllers\ContratoController::class, 'excluirCG'])->name('excluirCG');
		Route::post('contratos-gestao/{id_uniddae}/contratoExcluir/{escolha}', [App\Http\Controllers\ContratoController::class, 'destroyCG'])->name('destroyCG');
		Route::get('contratos-gestao/{id_unidade}/contratoInativar/{escolha}', [App\Http\Controllers\ContratoController::class, 'telaInativarCG'])->name('telaInativarCG');
		Route::post('contratos-gestao/{id_uniddae}/contratoInativar/{escolha}', [App\Http\Controllers\ContratoController::class, 'inativarCG'])->name('inativarCG');
		////

		//Demonstrativo Financeiro
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroCadastro', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'cadastroDF'])->name('cadastroDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroNovo', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'novoDF'])->name('novoDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroNovo', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'storeDF'])->name('storeDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroAlterar/{id_item}', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'alterarDF'])->name('alterarDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroAlterar/{id_item}', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'updateDF'])->name('updateDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroExcluir/{id_item}', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'excluirDF'])->name('excluirDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroExcluir/{id_item}', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'destroyDF'])->name('destroyDF');
		Route::get('demonstrativo-financeiro/{id_unidade}/financeiroInativar/{id_item}', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'telaInativarDF'])->name('telaInativarDF');
		Route::post('demonstrativo-financeiro/{id_unidade}/financeiroInativar/{id_item}', [App\Http\Controllers\DemonstrativoFinanceiroController::class, 'inativarDF'])->name('inativarDF');
		////

		//Demonstrativo Contabil
		Route::get('demonstrativo-contabel/{id_unidade}/contabelCadastro', [App\Http\Controllers\DemonstracaoContabelController::class, 'cadastroDC'])->name('cadastroDC');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelNovo', [App\Http\Controllers\DemonstracaoContabelController::class, 'novoDC'])->name('novoDC');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelNovo', [App\Http\Controllers\DemonstracaoContabelController::class, 'storeDC'])->name('storeDC');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelExcluir/{id_item}', [App\Http\Controllers\DemonstracaoContabelController::class, 'excluirDC'])->name('excluirDC');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelExcluir/{id_item}', [App\Http\Controllers\DemonstracaoContabelController::class, 'destroyDC'])->name('destroyDC');
		Route::get('demonstrativo-contabel/{id_unidade}/contabelInativar/{id_item}', [App\Http\Controllers\DemonstracaoContabelController::class, 'telaInativarDC'])->name('telaInativarDC');
		Route::post('demonstrativo-contabel/{id_unidade}/contabelInativar/{id_item}', [App\Http\Controllers\DemonstracaoContabelController::class, 'inativarDC'])->name('inativarDC');
		////
		
		//Repasses Recebidos	
		Route::get('repasses-recebidos/{id}/repassesCadastro', [App\Http\Controllers\RepasseController::class, 'cadastroRP'])->name('cadastroRP');
		Route::get('repasses-recebidos/{id}/repassesNovo', [App\Http\Controllers\RepasseController::class, 'novoRP'])->name('novoRP');
		Route::post('repasses-recebidos/{id}/repassesNovo', [App\Http\Controllers\RepasseController::class, 'storeRP'])->name('storeRP');
		Route::get('repasses-recebidos/{id_unidade}/repassesAlterar/{id_item}', [App\Http\Controllers\RepasseController::class, 'alterarRP'])->name('alterarRP');
		Route::post('repasses-recebidos/{id_unidade}/repassesAlterar/{id_item}', [App\Http\Controllers\RepasseController::class, 'updateRP'])->name('updateRP');
		Route::get('repasses-recebidos/{id}/repassesExcluir/{id_item}', [App\Http\Controllers\RepasseController::class, 'excluirRP'])->name('excluirRP');
		Route::post('repasses-recebidos/{id_unidade}/repassesExcluir/{id_item}', [App\Http\Controllers\RepasseController::class, 'destroyRP'])->name('destroyRP');
		Route::get('repasses-recebidos/{id}/repassesInativar/{id_item}', [App\Http\Controllers\RepasseController::class, 'telaInativarRP'])->name('telaInativarRP');
		Route::post('repasses-recebidos/{id_unidade}/repassesInativar/{id_item}', [App\Http\Controllers\RepasseController::class, 'inativarRP'])->name('inativarRP');
		////

	    //Contratacoes
		Route::get('contratacao/{id}/contratacaoCadastro', [App\Http\Controllers\ContratacaoController::class, 'contratacaoCadastro'])->name('contratacaoCadastro');
		Route::get('contratacao/{id}/cadastroContratos/', [App\Http\Controllers\ContratacaoController::class, 'cadastroContratos'])->name('cadastroContratos');
		Route::get('contratacao/{id}/relatorioContratosPJ/{id_}', [App\Http\Controllers\ContratacaoController::class, 'relatorioContratosPJ'])->name('relatorioContratosPJ');
		Route::get('contratacao/{id}/cadastroResponsavel', [App\Http\Controllers\ContratacaoController::class, 'responsavelCadastro'])->name('responsavelCadastro');
		Route::get('contratacao/{id}/validarResponsavel/{id_contrato}/{id_gestor}', [App\Http\Controllers\ContratacaoController::class, 'validarGestorContrato'])->name('validarGestorContrato');
		Route::get('contratacao/{id}/excluirContratos/{id_contrato}', [App\Http\Controllers\ContratacaoController::class, 'excluirContratos'])->name('excluirContratos');
		Route::get('contratacao/{id}/excluirCotacoes/{id_cotacao}', [App\Http\Controllers\ContratacaoController::class, 'excluirCotacoes'])->name('excluirCotacoes');
		Route::get('contratacao/{id}/validarCotacoes/{id_cotacao}', [App\Http\Controllers\ContratacaoController::class, 'validarCotacoes'])->name('validarCotacoes');
		Route::get('contratacao/{id}/alterarContratos/{id_contrato}/{id_prestador}', [App\Http\Controllers\ContratacaoController::class, 'alterarContratos'])->name('alterarContratos');
		Route::get('contratacao/{id}/alterarAditivo/{id_aditivo}/{id_contrato}', [App\Http\Controllers\ContratacaoController::class, 'alterarAditivo'])->name('alterarAditivo');
		Route::get('contratacao/{id}/cadastroCotacoes/addCotacao', [App\Http\Controllers\ContratacaoController::class, 'addCotacao'])->name('addCotacao');
		Route::get('contratacao/{id}/cadastroArquivosCotacoes/{id_processo}', [App\Http\Controllers\ContratacaoController::class, 'arquivosCotacoes'])->name('arquivosCotacoes');
		Route::post('contratacao/{id}/alterarContratos/{id_contrato}/{id_prestador}', [App\Http\Controllers\ContratacaoController::class, 'updateContratos'])->name('updateContratos');
		Route::post('contratacao/{id}/alterarAditivo/{id_contrato}/{id_prestador}', [App\Http\Controllers\ContratacaoController::class, 'updateAditivo'])->name('updateAditivo');
		Route::post('contratacao/{id}/excluirContratos/{id_contrato}', [App\Http\Controllers\ContratacaoController::class, 'destroy'])->name('destroy');
		Route::get('contratacao/{id}/excluirContratos/{id_aditivo}/{id_prestador}', [App\Http\Controllers\ContratacaoController::class, 'excluirAditivos'])->name('excluirAditivos');
		Route::get('contratacao/{id}/excluirAditivos/{id_aditivo}', [App\Http\Controllers\ContratacaoController::class, 'excluirAditivo'])->name('excluirAditivo');
		Route::post('contratacao/{id}/excluirAditivos/{id_aditivo}', [App\Http\Controllers\ContratacaoController::class, 'destroyAditivo'])->name('destroyAditivo');
		//Prestador
		Route::get('contratacao/{id}/cadastroPrestador', [App\Http\Controllers\ContratacaoController::class, 'prestadorCadastro'])->name('prestadorCadastro');
		Route::get('contratacao/{id}/cadastroPrestadorAlterar/{id_p}', [App\Http\Controllers\ContratacaoController::class, 'prestadorAlterar'])->name('prestadorAlterar');
		Route::post('contratacao/{id}/cadastroPrestadorAlterar/{id_p}', [App\Http\Controllers\ContratacaoController::class, 'updatePrestador'])->name('updatePrestador');
		Route::get('contratacao/{id}/cadastroPrestadorInativar/{id_p}', [App\Http\Controllers\ContratacaoController::class, 'prestadorInativar'])->name('prestadorInativar');
		Route::post('contratacao/{id}/cadastroPrestadorInativar/{id_p}', [App\Http\Controllers\ContratacaoController::class, 'inativarPrestador'])->name('inativarPrestador');
		Route::get('contratacao/{id}/cadastroContratos/pesquisarPrestador/', [App\Http\Controllers\ContratacaoController::class, 'pesquisarPrestador'])->name('pesquisarPrestador');
		Route::post('contratacao/{id}/cadastroContratos/procurarPrestador', [App\Http\Controllers\ContratacaoController::class, 'procurarPrestador'])->name('procurarPrestador');
		Route::get('contratacao/{id}/cadastroContratos/{id_prestador}', [App\Http\Controllers\ContratacaoController::class, 'pesqPresdator'])->name('pesqPresdator');
		Route::get('contratacao/{id}/prestadorLista', [App\Http\Controllers\ContratacaoController::class, 'prestadorLista'])->name('prestadorLista');
		Route::post('contratacao/{id}/prestadorLista/pesquisa', [App\Http\Controllers\ContratacaoController::class, 'procurarPrestadorCad'])->name('procurarPrestadorCad');
		//
		Route::get('contratacao/{id}/responsavelNovo/{id_contrato}/{id_gestor}', [App\Http\Controllers\ContratacaoController::class, 'excluirGestorContrato'])->name('excluirGestorContrato');
		Route::post('contratacao/{id}/responsavelNovo/{id_contrato}/{id_gestor}', [App\Http\Controllers\ContratacaoController::class, 'destroyGestorContrato'])->name('destroyGestorContrato');
		Route::get('contratacao/{id}/contratacaoDuvidas', [App\Http\Controllers\ContratacaoController::class, 'contratacaoDuvidas'])->name('contratacaoDuvidas');
		//Responsável
		Route::get('contratacao/{id}/responsavelCadastro', [App\Http\Controllers\GestorController::class, 'cadastroGE'])->name('cadastroGE');
		Route::get('contratacao/{id}/responsavelNovo', [App\Http\Controllers\GestorController::class, 'novoGE'])->name('novoGE');
		Route::post('contratacao/{id}/responsavelNovo', [App\Http\Controllers\GestorController::class, 'storeGE'])->name('storeGE');
		Route::get('contratacao/{id}/responsavelNovo/excluir/{id_g}', [App\Http\Controllers\GestorController::class, 'excluirContratoGestor'])->name('excluirContratoGestor');
		Route::get('contratacao/{id}/responsavelInativar/{id_g}', [App\Http\Controllers\GestorController::class, 'telaInativarGE'])->name('telaInativarGE');
		Route::post('contratacao/{id}/responsavelInativar/{id_g}', [App\Http\Controllers\GestorController::class, 'inativarGE'])->name('inativarGE');
		Route::get('contratacao/{id}/responsavelAlterar/{id_g}', [App\Http\Controllers\GestorController::class, 'alterarGE'])->name('alterarGE');
		Route::post('contratacao/{id}/responsavelAlterar/{id_g}', [App\Http\Controllers\GestorController::class, 'updateGE'])->name('updateGE');
		////
		
		//RegulamentosContratos
		Route::get('contratacao/{id}/contratacaoCadastro/regulamentos', [App\Http\Controllers\RegulamentosContratosController::class, 'regulamentosContratosCadastro'])->name('regulamentosContratosCadastro');
		Route::get('contratacao/{id}/contratacaoCadastro/regulamentos/novo', [App\Http\Controllers\RegulamentosContratosController::class, 'novoRC'])->name('novoRC');
		Route::post('contratacao/{id}/contratacaoCadastro/regulamentos/novo', [App\Http\Controllers\RegulamentosContratosController::class, 'storeRC'])->name('storeRC');
		Route::get('contratacao/{id}/contratacaoCadastro/regulamentos/inativar/{id_r}', [App\Http\Controllers\RegulamentosContratosController::class, 'telaInativarRC'])->name('telaInativarRC');
		Route::post('contratacao/{id}/contratacaoCadastro/regulamentos/inativar/{id_r}', [App\Http\Controllers\RegulamentosContratosController::class, 'inativarRC'])->name('inativarRC');
		////

		//Cotacoes
		Route::get('contratacao/{id}/cadastroCotacoes', [App\Http\Controllers\ContratacaoController::class, 'cadastroCotacoes'])->name('cadastroCotacoes');
		Route::get('contratacao/{id}/cadastroCotacoes/cotacoesNovo', [App\Http\Controllers\ContratacaoController::class, 'cotacoesNovo'])->name('cotacoesNovo');
		Route::get('contratacao/{id}/cadastroCotacoes/excluirCotacoes/{id_cotacao}', [App\Http\Controllers\ContratacaoController::class, 'excluirCotacoes'])->name('excluirCotacoes');
		Route::post('contratacao/{id}/cadastroCotacoes/excluirCotacoes/{id_cotacao}', [App\Http\Controllers\ContratacaoController::class, 'destroyCotacao'])->name('destroyCotacao');
		////

		//RH - SeleçãoPessoal
		Route::get('recursos-humanos/{id}/selecaoPCadastro', [App\Http\Controllers\RHController::class, 'cadastroSP'])->name('cadastroSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo', [App\Http\Controllers\RHController::class, 'novoSP'])->name('novoSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo', [App\Http\Controllers\RHController::class, 'storeSP'])->name('storeSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo/selecaoPCargos', [App\Http\Controllers\RHController::class, 'cargosSP'])->name('cargosSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPNovo/selecaoPCargos', [App\Http\Controllers\RHController::class, 'storeCargosSP'])->name('storeCargosSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPAlterar/{id_item}', [App\Http\Controllers\RHController::class, 'alterarSP'])->name('alterarSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPAlterar/{id_item}', [App\Http\Controllers\RHController::class, 'updateSP'])->name('updateSP');
		Route::get('recursos-humanos/{id}/selecaoPCadastro/selecaoPExcluir/{id_item}', [App\Http\Controllers\RHController::class, 'excluirSP'])->name('excluirSP');
		Route::post('recursos-humanos/{id}/selecaoPCadastro/selecaoPExcluir/{id_item}', [App\Http\Controllers\RHController::class, 'destroySP'])->name('destroySP');

		//DespesasPessoais
		Route::get('recursos-humanos/{id}/despesas', [App\Http\Controllers\DespesasPessoaisController::class, 'cadastroDRH'])->name('cadastroDRH');
		Route::post('recursos-humanos/{id}/despesas', [App\Http\Controllers\DespesasPessoaisController::class, 'storeDRH'])->name('storeDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/despesasRH', [App\Http\Controllers\RHController::class, 'despesasRH'])->name('despesasRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/despesasRH', [App\Http\Controllers\RHController::class, 'despesasRHProcurar'])->name('despesasRHProcurar');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/excluirDespesasRH', [App\Http\Controllers\RHController::class, 'excluirDRH'])->name('excluirDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/excluirDespesasRH', [App\Http\Controllers\RHController::class, 'destroyDRH'])->name('destroyDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/alterarDespesaRH/{ano}/{mes}/{tipo}', [App\Http\Controllers\RHController::class, 'alterarDRH'])->name('alterarDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/alterarDespesaRH/{ano}/{mes}/{tipo}', [App\Http\Controllers\RHController::class, 'updateDRH'])->name('updateDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/inativarDespesaRH/{ano}/{mes}/{tipo}/{tp}', [App\Http\Controllers\RHController::class, 'telaInativarDRH'])->name('telaInativarDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/inativarDespesaRH/{ano}/{mes}/{tipo}/{tp}', [App\Http\Controllers\RHController::class, 'inativarDRH'])->name('inativarDRH');
		Route::get('recursos-humanos/{id}/selecaoPcadastro/deletarDespesaRH/{ano}/{mes}/{tipo}', [App\Http\Controllers\RHController::class, 'deletarRH'])->name('deletarDRH');
		Route::post('recursos-humanos/{id}/selecaoPcadastro/deletarDespesaRH/{ano}/{mes}/{tipo}', [App\Http\Controllers\RHController::class, 'destroyDRH'])->name('destroyDRH');
		////

		//RH - Processo Seletivo
		Route::get('recursos-humanos/{id}/processoSCadastro', [App\Http\Controllers\RHController::class, 'cadastroPS'])->name('cadastroPS');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSNovo', [App\Http\Controllers\RHController::class, 'novoPS'])->name('novoPS');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSNovo', [App\Http\Controllers\RHController::class, 'storePS'])->name('storePS');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSExcluir/{id_item}', [App\Http\Controllers\RHController::class, 'excluirPS'])->name('excluirPS');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSExcluir/{id_item}', [App\Http\Controllers\RHController::class, 'destroyPS'])->name('destroyPS');
		Route::get('recursos-humanos/{id}/processoSCadastro/processoSInativar/{id_item}', [App\Http\Controllers\RHController::class, 'telaInativarPS'])->name('telaInativarPS');
		Route::post('recursos-humanos/{id}/processoSCadastro/processoSInativar/{id_item}', [App\Http\Controllers\RHController::class, 'inativarPS'])->name('inativarPS');
		////

		//RH - SP Cedidos
		Route::get('recursos-humanos/{id}/servidoresPCadastro', [App\Http\Controllers\RHController::class, 'servidoresPCadastro'])->name('servidoresPCadastro');

		//RH - Regulamento
		Route::get('recursos-humanos/{id}/regulamentoCadastro', [App\Http\Controllers\RHController::class, 'regulamentoCadastro'])->name('regulamentoCadastro');
		Route::get('recursos-humanos/{id}/regulamentoCadastros', [App\Http\Controllers\RegulamentosRhController::class, 'index'])->name('regulamentosRhCadastros');
		Route::get('recursos-humanos/{id}/regulamentoCreate', [App\Http\Controllers\RegulamentosRhController::class, 'create'])->name('regulamentosRhCreate');
		Route::post('recursos-humanos/{id}/regulamentoStore', [App\Http\Controllers\RegulamentosRhController::class, 'store'])->name('regulamentosRhStore');
		Route::get('recursos-humanos/{id}/{unidade_id}/regulamentoEdit', [App\Http\Controllers\RegulamentosRhController::class, 'edit'])->name('regulamentosRhEdit');
		Route::post('recursos-humanos/{id}/{unidade_id}/regulamentoUpdate', [App\Http\Controllers\RegulamentosRhController::class, 'update'])->name('regulamentosRhUpdate');
	    Route::post('recursos-humanos/{id}/{unidade_id}/regulamentoStatus', [App\Http\Controllers\RegulamentosRhController::class, 'status'])->name('regulamentosRhStatus');
		////
		
		//Regulamento
		Route::get('regulamento/{id}/regulamentoCadastro', [App\Http\Controllers\RegulamentoController::class, 'cadastroRG'])->name('cadastroRG');
		Route::get('regulamento/{id}/regulamentoNovo', [App\Http\Controllers\RegulamentoController::class, 'novoRG'])->name('novoRG');
		Route::post('regulamento/{id}/regulamentoNovo', [App\Http\Controllers\RegulamentoController::class, 'storeRG'])->name('storeRG');
		Route::get('regulamento/{id}/regulamentoExcluir/{id_escolha}', [App\Http\Controllers\RegulamentoController::class, 'excluirRG'])->name('excluirRG');
		Route::post('regulamento/{id}/regulamentoExcluir/{id_escolha}', [App\Http\Controllers\RegulamentoController::class, 'destroyRG'])->name('destroyRG');
		Route::get('regulamento/{id}/regulamentoInativar/{id_escolha}', [App\Http\Controllers\RegulamentoController::class, 'telaInativarRG'])->name('telaInativarRG');
		Route::post('regulamento/{id}/regulamentoInativar/{id_escolha}', [App\Http\Controllers\RegulamentoController::class, 'inativarRG'])->name('inativarRG');
		////

		//Estatuto/Ata
		Route::get('estatuto/{id}/estatutoCadastro', [App\Http\Controllers\EstatutoController::class, 'cadastroES'])->name('cadastroES');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoNovo', [App\Http\Controllers\EstatutoController::class, 'novoES'])->name('novoES');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoNovo', [App\Http\Controllers\EstatutoController::class, 'storeES'])->name('storeES');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoExcluir/{id_estatuto}', [App\Http\Controllers\EstatutoController::class, 'excluirES'])->name('excluirES');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoExcluir/{id_estatuto}', [App\Http\Controllers\EstatutoController::class, 'destroyES'])->name('destroyES');
		Route::get('estatuto/{id}/estatutoCadastro/estatutoInativar/{id_estatuto}', [App\Http\Controllers\EstatutoController::class, 'telaInativarES'])->name('telaInativarES');
		Route::post('estatuto/{id}/estatutoCadastro/estatutoInativar/{id_estatuto}', [App\Http\Controllers\EstatutoController::class, 'inativarES'])->name('inativarES');
		////

		//DocumentosRegularidade
		Route::get('documentos/{id}/documentosCadastro', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'cadastroDR'])->name('cadastroDR');
		Route::get('documentos/{id}/documentosCadastro/documentosNovo', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'novoDR'])->name('novoDR');
		Route::post('documentos/{id}/documentosCadastro/documentosNovo', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'storeDR'])->name('storeDR');
		Route::get('documentos/{id}/documentosCadastro/documentosExcluir/{id_escolha}', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'excluirDR'])->name('excluirDR');
		Route::post('documentos/{id}/documentosCadastro/documentosExcluir/{id_escolha}', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'destroyDR'])->name('destroyDR');
		Route::get('documentos/{id}/documentosCadastro/documentosInativar/{id_escolha}', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'telaInativarDR'])->name('telaInativarDR');
		Route::post('documentos/{id}/documentosCadastro/documentosInativar/{id_escolha}', [App\Http\Controllers\DocumentacaoRegularidadeController::class, 'inativarDR'])->name('inativarDR');
		////

		//Decreto
		Route::get('decreto/{id}/decretoCadastro', [App\Http\Controllers\DecretoController::class, 'cadastroDE'])->name('cadastroDE');
		Route::get('decreto/{id}/decretoNovo', [App\Http\Controllers\DecretoController::class, 'novoDE'])->name('novoDE');
		Route::post('decreto/{id}/decretoNovo', [App\Http\Controllers\DecretoController::class, 'storeDE'])->name('storeDE');
		Route::get('decreto/{id}/decretoExcluir/{id_escolha}', [App\Http\Controllers\DecretoController::class, 'excluirDE'])->name('excluirDE');
		Route::post('decreto/{id}/decretoExcluir/{id_escolha}', [App\Http\Controllers\DecretoController::class, 'destroyDE'])->name('destroyDE');
		Route::get('decreto/{id}/decretoAlterar/{id_escolha}', [App\Http\Controllers\DecretoController::class, 'telaInativarDE'])->name('telaInativarDE');
		Route::post('decreto/{id}/decretoAlterar/{id_escolha}', [App\Http\Controllers\DecretoController::class, 'inativarDE'])->name('inativarDE');
		////
		
		//Covênio
		Route::get('covenio/{id}/cadastroCovenio', [App\Http\Controllers\CoveniosController::class, 'covenioCadastro'])->name('covenioCadastro');
		Route::get('covenio/{id}/covenioNovo', [App\Http\Controllers\CoveniosController::class, 'covenioNovo'])->name('covenioNovo');
		Route::get('covenio/{id}/excluirCovenio/{id_escolha}', [App\Http\Controllers\CoveniosController::class, 'covenioExcluir'])->name('covenioExcluir');
		Route::post('covenio/{id}/excluirCovenio/{id_escolha}', [App\Http\Controllers\CoveniosController::class, 'destroy'])->name('destroy');	
		////
		
		//RelatorioGerencial
		Route::get('relmensalExecucao/{id}', [App\Http\Controllers\IndexController::class, 'transparenciaRelatorioGerencial'])->name('transparenciaRelatorioGerencial');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial', [App\Http\Controllers\RelatorioGerencialController::class, 'cadastroRelGerencial'])->name('cadastroRelGerencial');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialNovo', [App\Http\Controllers\RelatorioGerencialController::class, 'relatorioGerencialNovo'])->name('relatorioGerencialNovo');
		Route::post('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialNovo', [App\Http\Controllers\RelatorioGerencialController::class, 'storeRelatorioG'])->name('storeRelatorioG');
		Route::get('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialExcluir/{id_rel}', [App\Http\Controllers\RelatorioGerencialController::class, 'relatorioGerencialExcluir'])->name('relatorioGerencialExcluir');
		Route::post('relmensalExecucao/{id}/cadastroRelGerencial/relatorioGerencialExcluir/{id_rel}', [App\Http\Controllers\RelatorioGerencialController::class, 'destroy'])->name('destroy');
		
		//ServidoresCedidos
		Route::get('servidoresCedidos/{id}', [App\Http\Controllers\ServidoresCedidosController::class, 'cadastroSE'])->name('cadastroSE');
		Route::get('servidoresCedidos/{id}/servidoresNovo', [App\Http\Controllers\ServidoresCedidosController::class, 'novoSE'])->name('novoSE');
		Route::post('servidoresCedidos/{id}/servidoresNovo/', [App\Http\Controllers\ServidoresCedidosController::class, 'storeSE'])->name('storeSE');
		Route::get('servidoresCedidos/{id}/servidoresAlterar/{id_servidor}', [App\Http\Controllers\ServidoresCedidosController::class, 'alterarSE'])->name('alterarSE');
		Route::post('servidoresCedidos/{id}/servidoresAlterar/{id_servidor}/', [App\Http\Controllers\ServidoresCedidosController::class, 'updateSE'])->name('updateSE');
		Route::get('servidoresCedidos/{id}/servidoresExcluir/{id_servidor}', [App\Http\Controllers\ServidoresCedidosController::class, 'excluirSE'])->name('excluirSE');
		Route::post('servidoresCedidos/{id}/servidoresExcluir/{id_servidor}', [App\Http\Controllers\ServidoresCedidosController::class, 'destroySE'])->name('destroySE');
		Route::get('servidoresCedidos/{id}/servidoresInativar/{id_servidor}', [App\Http\Controllers\ServidoresCedidosController::class, 'telaInativarSE'])->name('telaInativarSE');
		Route::post('servidoresCedidos/{id}/servidoresInativar/{id_servidor}', [App\Http\Controllers\ServidoresCedidosController::class, 'inativarSE'])->name('inativarSE');
		
		//Justificativa
		Route::get('servidoresCedidos/{id}/justificativaNovo/{i}', [App\Http\Controllers\ServidoresCedidosController::class, 'novoJS'])->name('novoJS');
		Route::post('servidoresCedidos/{id}/justificativaNovo/{i}', [App\Http\Controllers\ServidoresCedidosController::class, 'storeJS'])->name('storeJS');
		Route::get('servidoresCedidos/{id_u}/justificativaInativar/{id}', [App\Http\Controllers\ServidoresCedidosController::class, 'telaInativarJS'])->name('telaInativarJS');
		Route::post('servidoresCedidos/{id_u}/justificativaInativar/{id}', [App\Http\Controllers\ServidoresCedidosController::class, 'inativarJS'])->name('inativarJS');
		////

		//CertificadoIntegridade
		Route::get('certificado_integridade/{id}', [App\Http\Controllers\CertificadoIntegridadeController::class, 'cadastroCI'])->name('cadastroCI');
		Route::get('certificado_integridade/{id}/certificado_integridadeNovo', [App\Http\Controllers\CertificadoIntegridadeController::class, 'novoCI'])->name('novoCI');
		Route::post('certificado_integridade/{id}/certificado_integridadeNovo', [App\Http\Controllers\CertificadoIntegridadeController::class, 'storeCI'])->name('storeCI');
		Route::get('certificado_integridade/{id_u}/certificado_integridadeInativar/{id}', [App\Http\Controllers\CertificadoIntegridadeController::class, 'telaInativarCI'])->name('telaInativarCI');
		Route::post('certificado_integridade/{id_u}/certificado_integridadeInativar/{id}', [App\Http\Controllers\CertificadoIntegridadeController::class, 'inativarCI'])->name('inativarCI');
		////
		
		//RelatorioFinanceiro
		Route::get('relatorio_financeiro/{id}', [App\Http\Controllers\RelatorioFinanceiroController::class, 'cadastroRF'])->name('cadastroRF');
		Route::get('relatorio_financeiro/{id}/relatorioNovo', [App\Http\Controllers\RelatorioFinanceiroController::class, 'novoRF'])->name('novoRF');
		Route::post('relatorio_financeiro/{id}/relatorioNovo', [App\Http\Controllers\RelatorioFinanceiroController::class, 'storeRF'])->name('storeRF');
		Route::get('relatorio_financeiro/{id}/relatorioExcluir/{id_rel}', [App\Http\Controllers\RelatorioFinanceiroController::class, 'excluirRF'])->name('excluirRF');
		Route::post('relatorio_financeiro/{id}/relatorioExcluir/{id_rel}', [App\Http\Controllers\RelatorioFinanceiroController::class, 'destroyRF'])->name('destroyRF');
		Route::get('relatorio_financeiro/{id}/relatorioInativar/{id_rel}', [App\Http\Controllers\RelatorioFinanceiroController::class, 'telaInativarRF'])->name('telaInativarRF');
		Route::post('relatorio_financeiro/{id}/relatorioInativar/{id_rel}', [App\Http\Controllers\RelatorioFinanceiroController::class, 'inativarRF'])->name('inativarRF');
		////
		
		//Ouvidoria
		Route::get('ouvidoria/{id}', [App\Http\Controllers\OuvidoriaController::class, 'cadastroOV'])->name('cadastroOV');
		Route::get('ouvidoria/{id}/ouvidoriaNovo', [App\Http\Controllers\OuvidoriaController::class, 'novoOV'])->name('novoOV');
		Route::post('ouvidoria/{id}/ouvidoriaNovo', [App\Http\Controllers\OuvidoriaController::class, 'storeOV'])->name('storeOV');
		Route::get('ouvidoria/{id}/ouvidoriaAlterar/{id_ouvidoria}', [App\Http\Controllers\OuvidoriaController::class, 'alterarOV'])->name('alterarOV');
		Route::post('ouvidoria/{id}/ouvidoriaAlterar/{id_ouvidoria}', [App\Http\Controllers\OuvidoriaController::class, 'updateOV'])->name('updateOV');
		Route::get('ouvidoria/{id}/ouvidoriaExcluir/{id_ouvidoria}', [App\Http\Controllers\OuvidoriaController::class, 'excluirOV'])->name('excluirOV');
		Route::post('ouvidoria/{id}/ouvidoriaExcluir/{id_ouvidoria}', [App\Http\Controllers\OuvidoriaController::class, 'destroyOV'])->name('destroyOV');
		Route::get('ouvidoria/{id}/ouvidoriaInativar/{id_ouvidoria}', [App\Http\Controllers\OuvidoriaController::class, 'telaInativarOV'])->name('telaInativarOV');
		Route::post('ouvidoria/{id}/ouvidoriaInativar/{id_ouvidoria}', [App\Http\Controllers\OuvidoriaController::class, 'inativarOV'])->name('inativarOV');
		
		//Relatorios estatisticos
		Route::get('ouvidoria/relatorioEstatistico/{id}', [App\Http\Controllers\OuvidoriaController::class, 'cadastroOVRelatorioES'])->name('cadastroOVRelatorioES');
		Route::get('ouvidoria/relatorioEstatistico/novo/{id}', [App\Http\Controllers\OuvidoriaController::class, 'novoOVRelatorioES'])->name('novoOVRelatorioES');
		Route::post('ouvidoria/relatorioEstatistico/novo/{id}', [App\Http\Controllers\OuvidoriaController::class, 'storeOVRelatorioES'])->name('storeOVRelatorioES');
		Route::get('ouvidoria/relatorioEstatistico/alterar/{id}/{id_doc}', [App\Http\Controllers\OuvidoriaController::class, 'alterarOVRelatorioES'])->name('alterarOVRelatorioES');
		Route::post('ouvidoria/relatorioEstatistico/alterar/{id}/{id_doc}', [App\Http\Controllers\OuvidoriaController::class, 'updateOVRelatorioES'])->name('updateOVRelatorioES');
		Route::get('ouvidoria/relatorioEstatistico/inativar/{id}/{id_doc}', [App\Http\Controllers\OuvidoriaController::class, 'telaInativarOVRelatorioES'])->name('telaInativarOVRelatorioES');
		Route::post('ouvidoria/relatorioEstatistico/inativar/{id}/{id_doc}', [App\Http\Controllers\OuvidoriaController::class, 'inativarOVRelatorioES'])->name('inativarOVRelatorioES');
		////	
		
		//Usuário
		Route::get('usuarios/cadastroUsuarios', [App\Http\Controllers\UserController::class, 'cadastroUsuarios'])->name('cadastroUsuarios');
		Route::get('usuarios/cadastroUsuarios/pesquisa', [App\Http\Controllers\UserController::class, 'pesquisarUsuario'])->name('pesquisarUsuario');
		Route::post('usuarios/cadastroUsuarios/pesquisa', [App\Http\Controllers\UserController::class, 'pesquisarUsuario'])->name('pesquisarUsuario');
		Route::get('usuarios/cadastroUsuarios/novo', [App\Http\Controllers\UserController::class, 'cadastroNovoUsuario'])->name('cadastroNovoUsuario');
		Route::post('usuarios/cadastroUsuarios/novo', [App\Http\Controllers\UserController::class, 'storeUsuario'])->name('storeUsuario');
		Route::get('usuarios/cadastroUsuarios/alterar/{id}', [App\Http\Controllers\UserController::class, 'cadastroAlterarUsuario'])->name('cadastroAlterarUsuario');
		Route::post('usuarios/cadastroUsuarios/alterar/{id}', [App\Http\Controllers\UserController::class, 'updateUsuario'])->name('updateUsuario');
		Route::get('usuarios/cadastroUsuarios/excluir/{id}', [App\Http\Controllers\UserController::class, 'cadastroExcluirUsuario'])->name('cadastroExcluirUsuario');
		Route::post('usuarios/cadastroUsuarios/excluir/{id}', [App\Http\Controllers\UserController::class, 'destroyUsuario'])->name('destroyUsuario');
		////
		
		//Relatórios
		Route::get('/relatorios/{id}', [App\Http\Controllers\HomeController::class, 'relatorios'])->name('relatorios');
    	Route::get('/relatorio_total_contratos/{id}', [App\Http\Controllers\HomeController::class, 'relatorioTotalContratos'])->name('relatorioTotalContratos');
    	Route::post('/relatorio_total_contratos/{id}', [App\Http\Controllers\HomeController::class, 'relatorioPesqTotalContratos'])->name('relatorioPesqTotalContratos');
    	Route::get('/relatorio_despesas/{id}', [App\Http\Controllers\HomeController::class, 'relatorioDespesasAno'])->name('relatorioDespesasAno');
    	Route::get('/relatorio_despesas_unidade/{id}', [App\Http\Controllers\HomeController::class, 'relatorioDespesasUnidade'])->name('relatorioDespesasUnidade');
    	Route::get('/relatorio_despesas_unidade/{id}/pesquisa', [App\Http\Controllers\HomeController::class, 'relatorioPesquisaDespesas'])->name('relatorioPesquisaDespesas');
    	Route::post('/relatorio_despesas_unidade/{id}/pesquisa', [App\Http\Controllers\HomeController::class, 'relatorioPesquisaDespesas'])->name('relatorioPesquisaDespesas');
    	Route::get('/relatorio_ultimas_atualizacoes/{id}/relatorio', [App\Http\Controllers\HomeController::class, 'relatorioUltAtualizacoes'])->name('relatorioUltAtualizacoes');
    	Route::post('/relatorio_ultimas_atualizacoes/{id}/relatorio', [App\Http\Controllers\HomeController::class, 'relatorioPesqUltAtual'])->name('relatorioPesqUltAtual');
    	////
		
		//Assistencial
		Route::get('assistencial/{id}/assistencialCadastro', [App\Http\Controllers\AssistencialController::class, 'cadastroRA'])->name('cadastroRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialNovo', [App\Http\Controllers\AssistencialController::class, 'novoRA'])->name('novoRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialNovo', [App\Http\Controllers\AssistencialController::class, 'storeRA'])->name('storeRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialNovo/{id_escolha}', [App\Http\Controllers\AssistencialController::class, 'storeRA'])->name('storeRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialAlterar/{id_item}', [App\Http\Controllers\AssistencialController::class, 'alterarRA'])->name('alterarRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialAlterar/{id_item}', [App\Http\Controllers\AssistencialController::class, 'updateRA'])->name('updateRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialExcluir/{id_item}', [App\Http\Controllers\AssistencialController::class, 'excluirRA'])->name('excluirRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialExcluir/{id_item}', [App\Http\Controllers\AssistencialController::class, 'destroyRA'])->name('destroyRA');
		Route::get('assistencial/{id}/assistencialCadastro/assistencialInativar/{id_item}/{tp}', [App\Http\Controllers\AssistencialController::class, 'telaInativarRA'])->name('telaInativarRA');
		Route::post('assistencial/{id}/assistencialCadastro/assistencialInativar/{id_item}/{tp}', [App\Http\Controllers\AssistencialController::class, 'inativarRA'])->name('inativarRA');
		//Assistencial Covid
		Route::get('assistencial/{id}/cadastroAssistencialCovid', [App\Http\Controllers\AssistencialCovidController::class, 'cadastroRAC'])->name('cadastroRAC');
		Route::get('assistencial/{id}/cadastroAssistencialCovid/novo', [App\Http\Controllers\AssistencialCovidController::class, 'novoRAC'])->name('novoRAC');
		Route::post('assistencial/{id}/cadastroAssistencialCovid/novo', [App\Http\Controllers\AssistencialCovidController::class, 'storeRAC'])->name('storeRAC');
		Route::get('assistencial/pesquisarMesCovid/{mes}/{ano}', [App\Http\Controllers\AssistencialCovidController::class, 'pesquisarRAC'])->name('pesquisarRAC');
		Route::get('assistencial/{id}/excluirAssistencialCovid/{id_covid}', [App\Http\Controllers\AssistencialCovidController::class, 'excluirRAC'])->name('excluirRAC');
		////
		//Assistencial documentos
		Route::get('assistencialdocs/cadastro/{id_und}', [App\Http\Controllers\AssistencialDocController::class, 'cadastroRADOC'])->name('cadastroRADOC');
		Route::get('assistencialdocs/novo/{id_und}', [App\Http\Controllers\AssistencialDocController::class, 'novoRADOC'])->name('novoRADOC');
		Route::post('assistencialdocs/novo/{id_und}', [App\Http\Controllers\AssistencialDocController::class, 'storeRADOC'])->name('storeRADOC');
		Route::get('assistencialdocs/assistencialExcluir/{id_und}/{id_doc}', [App\Http\Controllers\AssistencialDocController::class, 'telaExcluirRADOC'])->name('telaExcluirRADOC');
		Route::post('assistencialdocs/assistencialExcluir/{id_und}/{id_doc}', [App\Http\Controllers\AssistencialDocController::class, 'destroyRADOC'])->name('destroyRADOC');
		Route::get('assistencialdocs/assistencialInativar/{id_und}/{id_doc}', [App\Http\Controllers\AssistencialDocController::class, 'telaInativarRADOC'])->name('telaInativarRADOC');
		Route::post('assistencialdocs/assistencialInativar/{id_und}/{id_doc}', [App\Http\Controllers\AssistencialDocController::class, 'inativarRADOC'])->name('inativarRADOC');
		
		//Stores
		Route::post('institucionalCadastro/{id}/institucionalNovo', [App\Http\Controllers\InstitucionalController::class, 'store'])->name('store');
		Route::post('contratacao/{id}/cadastroPrestador', [App\Http\Controllers\ContratacaoController::class, 'storePrestador'])->name('storePrestador');
		Route::post('contratacao/{id}/cadastroContratos', [App\Http\Controllers\ContratacaoController::class, 'storeContratos'])->name('storeContratos');
		Route::post('contratacao/{id}/cadastroContratos/{id_item}', [App\Http\Controllers\ContratacaoController::class, 'storeContratos'])->name('storeContratos');
		Route::post('contratacao/{id}/cadastroCotacoes/cotacoesNovo', [App\Http\Controllers\ContratacaoController::class, 'storeCotacoes'])->name('storeCotacoes');
		Route::post('contratacao/{id}/responsavelNovo/{id_contrato}', [App\Http\Controllers\ContratacaoController::class, 'storeGestor'])->name('storeGestor');
    	Route::post('covenio/{id}/covenioNovo', [App\Http\Controllers\CoveniosController::class, 'store'])->name('store');
		Route::post('permissao/{id}/permissaoNovo', [App\Http\Controllers\PermissaoController::class, 'store'])->name('store');
		Route::post('permissao/{id}/permissaoUsuarioNovo', [App\Http\Controllers\PermissaoController::class, 'storePermissaoUsuario'])->name('storePermissaoUsuario');
		Route::post('contratacao/{id}/cadastroCotacoes/addCotacao', [App\Http\Controllers\ContratacaoController::class, 'storeExcelCotacao'])->name('storeExcelCotacao');
		Route::post('contratacao/{id}/cadastroArquivosCotacoes/{id_processo}',[App\Http\Controllers\ContratacaoController::class, 'storeArquivoCotacao'])->name('storeArquivoCotacao');
		
		//Bens públicos
		Route::get('bens-publicos/cadastros/{id_und}', [App\Http\Controllers\BensPublicosController::class, 'cadastroBP'])->name('cadastroBP');
		Route::get('bens-publicos/novo/{id_und}', [App\Http\Controllers\BensPublicosController::class, 'novoBP'])->name('novoBP');
		Route::post('bens-publicos/store/{id_und}', [App\Http\Controllers\BensPublicosController::class, 'storeBP'])->name('storeBP');
		Route::get('bens-publicos/deletar/{id_und}/{id_bens}', [App\Http\Controllers\BensPublicosController::class, 'excluirBP'])->name('excluirBP');
		Route::post('bens-publicos/deletar/{id_und}/{id_bens}', [App\Http\Controllers\BensPublicosController::class, 'destroyBP'])->name('destroyBP');
		Route::get('bens-publicos/inativar/{id_und}/{id_bens}', [App\Http\Controllers\BensPublicosController::class, 'telaInativarBP'])->name('telaInativarBP');
		Route::post('bens-publicos/inativar/{id_und}/{id_bens}', [App\Http\Controllers\BensPublicosController::class, 'inativarBP'])->name('inativarBP');
		////
		
		//Processo de contratação de terceiros
		Route::get('contratacao/{id}/processContrataTerceiros/processoNovo', [App\Http\Controllers\ContratacaoController::class, 'ProcessContrataTerceirosCreate'])->name('ProcessContrataTerceirosCreate');
		Route::post('contratacao/{id}/processContrataTerceiros/processoNovo', [App\Http\Controllers\ContratacaoController::class, 'storeProcessContrataTerceiros'])->name('storeProcessContrataTerceiros');
		Route::get('contratacao/{id}/processContrataTerceiros/excluirProcesso/{id_cotacao}', [App\Http\Controllers\ContratacaoController::class, 'excluirProcessos'])->name('excluirProcessos');
		Route::post('contratacao/{id}/processContrataTerceiros/excluirProcesso/{id_cotacao}', [App\Http\Controllers\ContratacaoController::class, 'destroyProcessos'])->name('destroyProcessos');
		
		//Documentações
		Route::get('documentacoes/cadastros/{id_und}', [App\Http\Controllers\DocumentacaoController::class, 'cadastroDocumentacoes'])->name('cadastroDocumentacoes');
		Route::get('documentacoes/novo/{id_und}', [App\Http\Controllers\DocumentacaoController::class, 'novoDocumentacao'])->name('novoDocumentacao');
		Route::post('documentacoes/novo/{id_und}', [App\Http\Controllers\DocumentacaoController::class, 'storeDocumentacao'])->name('storeDocumentacao');
		Route::get('documentacoes/alterar/{id_und}/{id}', [App\Http\Controllers\DocumentacaoController::class, 'alterarDocumentacao'])->name('alterarDocumentacao');
		Route::post('documentacoes/alterar/{id_und}/{id}', [App\Http\Controllers\DocumentacaoController::class, 'updateDocumentacao'])->name('updateDocumentacao');
		Route::get('documentacoes/excluir/{id_und}/{id}', [App\Http\Controllers\DocumentacaoController::class, 'deleteDocumentacao'])->name('deleteDocumentacao');
		Route::post('documentacoes/excluir/{id_und}/{id}', [App\Http\Controllers\DocumentacaoController::class, 'destroyDocumentacao'])->name('destroyDocumentacao');

		//Órgãos
		Route::get('orgaos/cadastros/{id_und}', [App\Http\Controllers\OrgaosController::class, 'listarORG'])->name('listarORG');
		Route::get('orgaos/cadastros/{id_und}/pesquisa', [App\Http\Controllers\OrgaosController::class, 'pesquisaOrgaos'])->name('pesquisaOrgaos');
		Route::post('orgaos/cadastros/{id_und}/pesquisa', [App\Http\Controllers\OrgaosController::class, 'pesquisaOrgaos'])->name('pesquisaOrgaos');
		Route::get('orgaos/cadastros/{id_und}/novo', [App\Http\Controllers\OrgaosController::class, 'novoORG'])->name('novoORG');
		Route::post('orgaos/cadastros/{id_und}/novo', [App\Http\Controllers\OrgaosController::class, 'storeORG'])->name('storeORG');
		Route::get('orgaos/cadastros/{id_und}/alterar/{id}', [App\Http\Controllers\OrgaosController::class, 'alterarORG'])->name('alterarORG');
		Route::post('orgaos/cadastros/{id_und}/alterar/{id}', [App\Http\Controllers\OrgaosController::class, 'updateORG'])->name('updateORG');
		Route::get('orgaos/cadastros/{id_und}/inativar/{id}', [App\Http\Controllers\OrgaosController::class, 'telaInativarORG'])->name('telaInativarORG');
		Route::post('orgaos/cadastros/{id_und}/inativar/{id}', [App\Http\Controllers\OrgaosController::class, 'inativarORG'])->name('inativarORG');

		Route::get('/transparenciaContratos/{id}', [App\Http\Controllers\HomeController::class, 'transparenciaContratos'])->name('transparenciaContratos');
		Route::get('/transparenciaContratos/{id}/home_layout', [App\Http\Controllers\HomeController::class, 'homeContratosLayout'])->name('homeContratosLayout');
		Route::get('/transparenciaContratos/{id}/home_layout/pesquisa', [App\Http\Controllers\ContratosLayoutController::class, 'documentosPesquisa'])->name('documentosPesquisa');
		Route::post('/transparenciaContratos/{id}/home_layout/pesquisa', [App\Http\Controllers\ContratosLayoutController::class, 'documentosPesquisa'])->name('documentosPesquisa');
		// Rota para gerar Distrato
		Route::get('/gerarDistrato/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'gerarDistrato'])->name('gerarDistrato');
		Route::post('/gerarDistrato/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'distratoPdf'])->name('distratoPdf');
		// Gerar Renovação de Vigência
		Route::get('/gerarRenovacaoVigencia/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'gerarRenovacaoVig'])->name('gerarRenovacaoVig');
		Route::post('/gerarRenovacaoVigencia/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'renovacaoVig'])->name('renovacaoVig');
		// Gerar Contrato de Consultas e Exames
		Route::get('/gerarContratoConsExam/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'gerarContConsExam'])->name('gerarContConsExam');
		Route::post('/gerarContratoConsExam/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'contratoConsultasMed'])->name('contratoConsultasMed');
		// Gerar Contrato de Serviço Médico – Consultas (UPAE´s)
		Route::get('/gerarContratoServMedCons/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'gerarContratoServMedCons'])->name('contratoServMedCons');
		Route::post('/gerarContratoServMedCons/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'contratoServMedCons'])->name('contratoServMedCons');
		// Gerar Contratos de Serviços Médicos (Plantão)
		Route::get('/gerarContratoServMedPlant/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'gerarContServMedP'])->name('gerarContServMedP');
		Route::post('/gerarContratoServMedPlant/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'contratoServMedP'])->name('contratoServMedP');
		// Gerar Contratos – Consultas e Exames – HMR e UPAE Arruda
		Route::get('/contratoConsExamHmrArruda/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'gerarContratoConsExamHmrArruda'])->name('gerarContratoConsExamHmrArruda');
		Route::post('/contratoConsExamHmrArruda/{id}', [App\Http\Controllers\ContratosLayoutController::class, 'contratoConsExamHmrArruda'])->name('contratoConsExamHmrArruda');
		
	  });	 
});

Route::get('/admin', function(){
    return 'You are an admin inside contracts';
})->middleware('auth','auth.admin');