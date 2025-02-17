<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use App\Models\PermissaoUsers;
use App\Models\Unidade;
use App\Models\User;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Http\Request;
use Validator;
use DB;

class PermissaoController extends Controller
{
    public function __construct(Unidade $unidade, Permissao $permissao, PermissaoUsers $permissao_user)
	{
		$this->unidade   = $unidade;
		$this->permissao = $permissao;
		$this->permissao_user = $permissao_user;
	}
	
	public function index(Unidade $unidade)
	{
		$unidade = Unidade::all();
		return view ('transparencia.permissao', compact('unidades'));
	}
	
	public function cadastroPermissao($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidade      = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades     = $unidadesMenu;
		$userPermissao = DB::table('users')
		->join('permissao_user', 'users.id', '=', 'permissao_user.user_id')
		->select('users.name as Nome', 'users.id as id', 'permissao_user.user_id as user_id')->distinct()->get();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidades','unidadesMenu', 'userPermissao'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function permissaoNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function permissaoUsuarioNovo($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$users = User::all();
		$permissoes = Permissao::all();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_usuario_novo', compact('unidade','unidades','unidadesMenu','users','permissoes'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function permissaoAlterar($id, $id_usuario)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$permissoes = DB::table('permissao_user')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
		->join('permissao', 'permissao.id', '=', 'permissao_user.permissao_id')
		->join('unidades', 'unidades.id', '=', 'permissao_user.unidade_id')
		->select('permissao_user.*', 'users.name as Nome', 'permissao.tela as Permissao', 'unidades.name as Unidade')
		->where('permissao_user.user_id', $id_usuario)->get();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_alterar', compact('unidade','unidades','unidadesMenu','permissoes'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function permissaoSelecionadaAlterar($id, $id_usuario, $permissao_id)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$permissoesAll = Permissao::all();		
		$permissoes = DB::table('permissao_user')
				->join('users', 'permissao_user.user_id', '=', 'users.id')
				->join('permissao', 'permissao.id', '=', 'permissao_user.permissao_id')
				->join('unidades', 'unidades.id', '=', 'permissao_user.unidade_id')
				->select('permissao_user.*', 'users.name as Nome', 'permissao.tela as Permissao', 'unidades.owner as Unidade')
				->where('permissao_user.user_id', $id_usuario)->where('permissao_user.id', $permissao_id)->get();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_selecionada_alterar', compact('unidade','unidades','unidadesMenu','permissoesAll', 'permissoes'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function updatePermissao($id, $id_usuario, $permissao_id, Request $request){
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		if ($validacao == 'ok'){
			$validator = Validator::make($request->all(), [
    			'permissao_id'  => 'required',
    			'unidade_id'  => 'required'
    	    ]);
			if ($validator->fails()) {
    		    $failed    = $validator->failed();
    		    $validator = 'Preencha todos os campos corretamente!';
    			return redirect()->back()
            	    ->withErrors($validator)
            		->withInput(session()->flashInput($request->input()));
			} else {
				$input = $request->all();
				$permissaoSelecionada = PermissaoUsers::find($permissao_id);
				$permissaoSelecionada->update($input);
				$validator = 'Permissão Alterada com Sucesso!';
				return redirect()->route('permissaoAlterar', [$id, $id_usuario])
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
			}
			
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}
	
	public function permissaoExcluir($id, $id_usuario)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidad = Unidade::where('id', $id)->get();
		$permissoes = DB::table('permissao_user')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
		->join('permissao', 'permissao.id', '=', 'permissao_user.permissao_id')
		->join('unidades', 'unidades.id', '=', 'permissao_user.unidade_id')
		->select('permissao_user.*', 'users.name as Nome', 'permissao.tela as Permissao', 'unidades.name as Unidade')
		->where('permissao_user.user_id', $id_usuario)->get();
		if($validacao == 'ok') {
			return view('transparencia/permissao/permissao_excluir', compact('unidade','unidades', 'unidad','unidadesMenu','permissoes'));
		} else {
			$validator = 'Você não tem Permissão!!';		
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function deletePermissao($id, $permissao_id, $usuario_id){
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		if($validacao == 'ok'){
			DB::table('permissao_user')
			->where('id', $permissao_id)->delete();
			if(DB::table('permissao_user')->where('user_id', $usuario_id)->exists()){
				$validator = 'Permissão deletada com Sucesso!';
				return redirect()->back()
						->withErrors($validator);
			} else {
				$validator = 'Permissão deletada com Sucesso, nenhuma permissão existente vinculada ao usuário selecionado.';
				return redirect()->route('cadastroPermissao', [$id])
					->withErrors($validator);
			}
			
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
		
	}

	public function deletePermissoesAll($id, $usuario_id){
		$validacao = permissaoUsersController::Permissao($id);
		$unidade = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		if($validacao == 'ok'){
			DB::table('permissao_user')
			->where('user_id', $usuario_id)->delete();
			$validator = 'Todas as Permissões Vinculadas ao usuário Deletas com Sucesso';
			return redirect()->route('cadastroPermissao', [$id])
				->withErrors($validator)
				->with('unidades', 'unidade', 'unidadesMenu');
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
	}
	
	public function store($id, Request $request)
	{
		$unidade  = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$input 	  = $request->all();
		$input['unidade_id'] = $id;
		$permissao = Permissao::create($input);
		$lastUpdated = $permissao->max('updated_at');
		$permissoes  = DB::table('permissao_user')
		->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		->join('users', 'permissao_user.user_id', '=', 'users.id')
	    ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		->where('unidade_id', $id)
		->get();
		return view('transparencia/permissao/permissao_cadastro', compact('unidade','unidadesMenu','unidades','permissoes','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}
	
	public function storePermissaoUsuario($id, Request $request)
	{
		$unidade  = Unidade::find($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$input    = $request->all();
		$unidade  = $input['unidade'];
		$permissao = $input['permissao_id'];
		$permissoesAll = Permissao::all();

		if($unidade == 0 && $permissao == 0){
			for($i = 1; $i <= 9; $i++) {
				$input['unidade_id'] = $i;
				foreach($permissoesAll as $permiss){
					$input['permissao_id'] = $permiss->id;
					$permissaoCreate = PermissaoUsers::create($input);
				}
			}
		} else {
			if($unidade == 0 && $permissao != 0) {
				for($i = 1; $i <= 9; $i++) {
					$input['unidade_id'] = $i;
					$permissaoCreate = PermissaoUsers::create($input);
				}
			}

			if ($permissao == 0 && $unidade != 0){
				foreach($permissoesAll as $permiss){
					$input['permissao_id'] = $permiss->id;
					$permissaoCreate = PermissaoUsers::create($input);
				}
			}

			$input['unidade_id'] = $unidade;
			$input['permissao_id'] = $permissao;
			$permissaoCreate = PermissaoUsers::create($input);
		}
		$lastUpdated = $permissaoCreate->max('updated_at');
		$permissoes = DB::table('permissao_user')
		 ->join('permissao', 'permissao_user.permissao_id', '=', 'permissao.id')
		 ->join('users', 'permissao_user.user_id', '=', 'users.id')
	     ->select('permissao_user.*','users.name as Nome','permissao.tela','permissao.acao')
		 ->where('unidade_id', $id)->get();
		$unidade = Unidade::find($id);	
		$validator = 'Permissão cadastrada com sucesso!';
		return redirect()->route('cadastroPermissao', [$id])
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}
	
	public function destroy()
	{
		
	}	
}
