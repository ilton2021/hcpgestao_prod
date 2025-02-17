<?php

namespace App\Http\Controllers;

use App\Models\Gestor;
use App\Models\Contrato;
use App\Models\Unidade;
use App\Models\LoggerUsers;
use App\Models\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Validator;

class GestorController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->logger_users = $logger_users;
	}
	
	public function index()
    {
        $unidades = Associado::all();
		return view('home', compact('unidades')); 		
    }
	
	public function cadastroGE($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::find($id);
		$gestores     = Gestor::whereIN('unidade_id', ['1', $id])->get();
		$lastUpdated  = $gestores->max('last_updated');
		if($validacao == 'ok') {
			return view('transparencia/gestores/gestores_cadastro', compact('unidades','unidadesMenu','lastUpdated','unidade','gestores'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoGE($id_unidade, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidade::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$gestores  = Gestor::all();
		if ($validacao == 'ok') {
			return view('transparencia/gestores/gestores_novo', compact('unidades', 'unidade', 'unidadesMenu', 'gestores'));
		} else {
			$validator = 'Você não tem Permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function storeGE($id, Request $request)
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id);
		$validacao 	  = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$input    = $request->all();
			$validator = Validator::make($request->all(), [
				'nome'  => 'required|max:255',
				'email' => 'required|max:255|email',
				'setor' => 'required|max:255'
			]);
			if ($validator->fails()) {
				return view('transparencia/gestores/gestores_novo', compact('unidades', 'unidadesMenu', 'unidade'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['status_gestores'] = 1;
				$input['unidade_id']  = 1;
				$gestores 	  		  = Gestor::create($input);
				$id_registro 		  = DB::table('gestor')->max('id');
				$input['registro_id'] = $id_registro;
				$log 				  = LoggerUsers::create($input);
				$lastUpdated 		  = $log->max('updated_at');
				$gestores 	  		  = Gestor::all();
				$validator 			  = 'Gestor cadastrado com sucesso!';
				return  redirect()->route('cadastroGE', [$id])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarGE($id_unidade, $id_gestor, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidades     = Unidade::all();
		$unidade      = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$gestores     = Gestor::where('id', $id_gestor)->get();
		$lastUpdated  = $gestores->max('updated_at');
		if ($validacao == 'ok') {
			return view('transparencia/gestores/gestores_alterar', compact('unidades', 'unidade', 'unidadesMenu', 'lastUpdated', 'gestores'));
		} else {
			$validator = 'Você não tem Permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function updateGE($id_unidade, $id_gestor, Request $request)
	{
		$unidades     = Unidade::all();
		$unidade      = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$input    = $request->all();
			$validator = Validator::make($request->all(), [
				'nome'  => 'required|max:255',
				'email' => 'required|max:255|email',
				'setor' => 'required|max:255'
			]);
			if ($validator->fails()) {
				return view('transparencia/gestores/gestores_novo', compact('unidades', 'unidadesMenu', 'unidade'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['unidade_id']  = 1;
				$gestores 	  		  = Gestor::find($id_gestor);
				$gestores->update($input);
				$id_registro 		  = DB::table('gestor')->max('id');	
				$input['registro_id'] = $id_registro;
				$log 				  = LoggerUsers::create($input);
				$lastUpdated 		  = $log->max('updated_at');
				$gestores 	  		  = Gestor::all();
				$validator 			  = 'Gestor alterado com sucesso!';
				return  redirect()->route('cadastroGE', [$id_unidade])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarGE($id_unidade, $id_gestor, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id_unidade);
		$unidades  = Unidaded::all();
		$unidade   = Unidade::find($id_unidade);
		$unidadesMenu = Unidade::all();
		$gestores  = Gestor::where('id', $id_gestor)->get();
		if ($validacao == 'ok') {
			return view('transparencia/gestores/gestores_inativar', compact('unidades', 'unidade', 'unidadesMenu', 'gestores'));
		} else {
			$validator = 'Você não tem Permissão!!!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function inativarGE($id_unidade, $id_gestor, Request $request)
	{
		$input    = $request->all();
		$gestores = Gestor::where('id', $id_gestor)->get();
		if ($gestores[0]->status_gestores == 1) {
			DB::statement('UPDATE gestor SET status_gestores = 0 WHERE id = '.$id_gestor.';');
		} else {
			DB::statement('UPDATE gestor SET status_gestores = 1 WHERE id = '.$id_gestor.';');
		}
		$input['registro_id'] = $id_gestor;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$gestores     = Gestor::where('id',$id_gestor)->get();
		$validator    = 'Gestor inativado com sucesso!';
		return redirect()->route('cadastroGE', [$id_unidade])
				->withErrors($validator);
	}
}