<?php

namespace App\Http\Controllers;

use App\Models\ServidoresCedidosRH;
use App\Models\Unidade;
use App\Models\LoggerUsers;
use App\Models\PermissaoUsers;
use App\Models\Justificativa;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;

class ServidoresCedidosController extends Controller
{
    public function __construct(Unidade $unidade, ServidoresCedidosRH $servidores, Request $request, LoggerUsers $logger_users){
		$this->unidade 	  = $unidade;
		$this->servidores = $servidores;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
	public function index()
    {
        $unidades = Associado::all();
		return view('home', compact('unidades')); 		
    }
	
	public function cadastroSE($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->orderBy('nome','ASC')->get();
		$justificativa = Justificativa::where('unidade_id',$id_unidade)->where('tabela',1)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_cadastro', compact('unidades','unidadesMenu','unidade','servidores','justificativa'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function novoSE($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function storeSE($id_unidade, Request $request) 
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($validator->fails()) {
			return view('transparencia/servidores/servidor_novo', compact('unidades','unidadesMenu','unidade'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}else {
			$input['status_servidores'] = 1;
			$servidores  = ServidoresCedidosRH::create($input);
			$id_registro = DB::table('servidores_cedidos')->max('id');
			$input['registro_id'] = $id_registro;
			$log 		 = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores  = ServidoresCedidosRH::where('status_servidores',1)->where('unidade_id',$id_unidade)->orderby('nome','ASC')->get();
			$validator   = 'O Servidor Cedido, foi cadastrado com sucesso!';
			return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
		}
	}
	
	public function alterarSE($id_servidor, $id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id',$id_unidade)->where('id',$id_servidor)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function updateSE($id_servidor, $id_unidade, Request $request) 
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$input 		  = $request->all();
		$servidores   = ServidoresCedidosRH::where('unidade_id',$id_unidade)->where('id',$id_servidor)->get();
		$validator = Validator::make($request->all(), [
			'nome'   	   => 'required|max:255',
			'cargo'  	   => 'required|max:255',
			'matricula'    => 'required|max:255',
			'email'  	   => 'required|max:255',
			'fone'  	   => 'required|max:15',
			'data_inicio'  => 'required|date',
		]);		
		if ($validator->fails()) {
			return view('transparencia/servidores/servidor_alterar', compact('unidades','unidadesMenu','unidade','servidores'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}else {
			$servidores  = ServidoresCedidosRH::find($id_servidor); 
			$servidores->update($input);
			$input['registro_id'] = $id_servidor;
			$log 		 = LoggerUsers::create($input);
			$lastUpdated = $log->max('updated_at');
			$servidores  = ServidoresCedidosRH::where('unidade_id',$id_unidade)->orderby('nome','ASC')->get();
			$validator   = 'O servidor Cedido foi alterado com sucesso!';
			return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
		}
	}
	
	public function excluirSE($id_servidor, $id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_excluir', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarSE($id_servidor, $id_unidade, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$servidores = ServidoresCedidosRH::where('unidade_id', $id_unidade)->where('id', $id_servidor)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/servidor_inativar', compact('unidades','unidadesMenu','unidade','servidores'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function destroySE($id_servidor, $id_unidade, Request $request) {
		ServidoresCedidosRH::find($id_servidor)->delete();  
		$input 		  = $request->all();
		$input['registro_id'] = $id_servidor;
		$log 		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$servidores   = ServidoresCedidosRH::where('unidade_id',$id_unidade)->orderby('nome','ASC')->get();
		$validator    = 'Servidor Cedido Excluído com sucesso!';
		return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
	}

	public function inativarSE($id_servidor, $id_unidade, Request $request) {
		$input     = $request->all();
		$servidores = ServidoresCedidosRH::where('id',$id_servidor)->get();
		if($servidores[0]->status_servidores == 1) {
			DB::statement('UPDATE servidores_cedidos SET status_servidores = 0 WHERE id = '.$id_servidor.';');
		} else {
			DB::statement('UPDATE servidores_cedidos SET status_servidores = 1 WHERE id = '.$id_servidor.';');
		}
		$input['registro_id'] = $id_servidor;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$servidores   = ServidoresCedidosRH::where('id',$id_servidor)->get();
		$validator    = 'Servidores inativado com sucesso!';
		return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
	}
	
	public function novoJS($id_unidade, $id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id_unidade);
		if($id == 1) { $tela = 'SERVIDOR'; } else if ($id == 2) { $tela = 'OBRAS'; } 
		else if ($id == 3) { $tela = 'AQUISIÇÃO'; }else if($id == 4){$tela = 'Recursos humanos - Regulamentos';}
		$justificativas = Justificativa::where('unidade_id', $id_unidade)->orderBy('nome','ASC')->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/justificativa_novo', compact('unidades','unidadesMenu','unidade','justificativas','tela','id'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeJS($id_unidade, $id, Request $request)
    { 
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$justificativa = Justificativa::where('unidade_id', $id_unidade)->get();
        $lastUpdated = $justificativa->max('updated_at');
		$input 		 = $request->all();
		$nome 		 = $_FILES['file_path']['name']; 
		$extensao 	 = pathinfo($nome, PATHINFO_EXTENSION);
		if($id == 1) { $tela = 'SERVIDOR'; } else if ($id == 2) { $tela = 'OBRAS'; } else if ($id == 3) { $tela = 'AQUISIÇÃO'; }
		if($request->file('file_path') === NULL) {	
			$validator = 'Informe o arquivo da Justificativa!';
			return view('transparencia/servidores/justificativa_novo', compact('unidades','unidade','unidadesMenu','justificativa','lastUpdated','tela','id'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
		    $extensao = strtolower($extensao);
			if($extensao === 'pdf') {
				$validator = Validator::make($request->all(), [
					'nome' => 'required|max:255',
					'mes'  => 'required',
					'ano'  => 'required'
				]);
				if ($validator->fails()) {
					$failed    = $validator->failed();
					$validator = 'Preencha todos os campos corretamente!';
					return view('transparencia/servidores/justificativa_novo', compact('unidades','unidade','unidadesMenu','justificativa','lastUpdated','tela','id'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}			
				$unidade  = Unidade::find($id_unidade);
				$input['tabela']   = $id;			
				$tipo = ''; 
				if($id == 1) { $tipo = 'servidores'; } 
				else if($id == 2) { $tipo = 'obras'; }
				else if($id == 3) { $tipo = 'aquisicao'; } 
				$request->file('file_path')->move('../public/storage/justificativa/'.$tipo.'/'.$unidade->sigla.'/',$nome);
				$input['caminho']  = 'justificativa/'.$tipo.'/'.$unidade->sigla.'/'.$nome;
				$input['name_arq'] = $nome;
				$input['status']   = 0;
 				$justificativa     = Justificativa::create($input);	
				$id_registro 		  = DB::table('justificativa')->max('id');
				$input['registro_id'] = $id_registro;
				$log 	 		      = LoggerUsers::create($input);
				$lastUpdated	      = $log->max('updated_at');
				$justificativa        = Justificativa::where('unidade_id',$id_unidade)->get();
				$validator 			  = 'Justificativa cadastrada com sucesso!';
				if($id == 1) {
					return redirect()->route('cadastroSE', [$id_unidade])
						->withErrors($validator);				
				} else {
					return redirect()->route('transparenciaContratacao', [$id_unidade])
						->withErrors($validator);				
				}
			} else {
				$validator 	   = 'Só suporta arquivos do tipo: PDF!';	
				$justificativa = Justificativa::where('unidade_id',$id_unidade)->get();
				$lastUpdated   = $justificativa->max('updated_at');
				return view('transparencia/servidores/justificativa_novo', compact('unidades','unidade','unidadesMenu','justificativa','lastUpdated','tela','id'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}
	}

	public function telaInativarJS($id_unidade, $id)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id_unidade);
		$justificativa = Justificativa::where('id', $id)->where('unidade_id',$id_unidade)->get();
		if($validacao == 'ok') {
			return view('transparencia/servidores/justificativa_inativar', compact('unidades','unidadesMenu','unidade','justificativa'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function inativarJS($id_unidade, $id_item, Request $request)
	{
		$input = $request->all();
		$justificativa = Justificativa::where('id',$id_item)->get(); 
		if($justificativa[0]->status == 1) {
		    $delimitador = $justificativa[0]->name_arq;
			$nomeArq    = explode($delimitador, $justificativa[0]->caminho);
			$nome       = explode("old_", $justificativa[0]->name_arq);
			$image_path = $nomeArq[0].$nome[1];  
			DB::statement("UPDATE justificativa SET `status` = 0, `caminho` = '$image_path', `name_arq` = '$nome[1]' WHERE `id` = $id_item");
			$image_path = 'storage/'.$image_path;
			$caminho    = 'storage/'.$justificativa[0]->caminho;
			rename($caminho, $image_path);
			$validator     = 'Justificativa ativada com sucesso!';
		} else {
		    $nomeArq    = explode($justificativa[0]->name_arq, $justificativa[0]->caminho);
			$nome       = "old_".$justificativa[0]->name_arq;   
			$image_path = $nomeArq[0].$nome;  
			DB::statement("UPDATE justificativa SET `status` = 1, `caminho` = '$image_path', `name_arq` = '$nome' WHERE `id` = $id_item");
			$image_path = 'storage/'.$image_path; 
			$caminho    = 'storage/'.$justificativa[0]->caminho; 
			rename($caminho, $image_path);
			$validator     = 'Justificativa inativada com sucesso!';
		}
		$input['registro_id'] = $id_item;
		$logger        = LoggerUsers::create($input);
		$lastUpdated   = $logger->max('updated_at');
        $unidadesMenu  = Unidade::where('status_unidades',1)->get();
		$unidades 	   = $unidadesMenu;
		$unidade       = Unidade::where('status_unidades',1)->find($id_unidade);
		$justificativa = Justificativa::where('unidade_id',$id_unidade)->get();
		return redirect()->route('cadastroSE', [$id_unidade])
				->withErrors($validator);
    }
}