<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orgaos;
use App\Models\Unidade;
use App\Models\LoggerUsers;
use App\Models\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class OrgaosController extends Controller
{
    public function __construct(Unidade $unidade, Request $request, Orgaos $orgaos, LoggerUsers $logger_users)
	{
		$this->unidade 		= $unidade;
		$this->request 		= $request;
		$this->orgaos       = $orgaos;
		$this->logger_users = $logger_users;
	}

	public function index()
	{
		$orgaos = Orgaos::where('status', 1)->get();
		return view('orgaos/cadastro_orgaos', compact('orgaos'));
	}

	public function listarORG($id, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::where('status_unidades', 1)->get();
		$unidades     = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades', 1)->find($id);
		if ($validacao == 'ok') {
			$orgaos = Orgaos::paginate(30);
			return view('orgaos/cadastro_orgaos', compact('unidade', 'unidades', 'unidadesMenu', 'orgaos'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function novoORG($id, Request $request)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id);
		if ($validacao == 'ok') {
			$orgaos = Orgaos::paginate(20);
			return view('orgaos/orgaos_novo', compact('unidade', 'unidades', 'unidadesMenu', 'orgaos'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

    public function storeORG($id, Request $request)
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id);
		$validacao 	  = permissaoUsersController::Permissao($id);
		if ($validacao == 'ok') {
			$input = $request->all();
			$orgaos = Orgaos::all();
			$validator = Validator::make($request->all(), [
				'nome' => 'required|max:255'
			]);
			if ($validator->fails()) {
				$failed = $validator->failed();
				$validator = 'Algo de errado aconteceu, verifique os campos e preencha novamente!';
				return view('orgaos/orgaos_novo', compact('unidades', 'unidadesMenu', 'unidade', 'orgaos'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			} else {
				$input['status']      = 0;
                $input['unidade_id']  = $id;
                $input['user_id']     = Auth::user()->id;
 				$orgaos 	          = Orgaos::create($input);
				$id_registro 		  = DB::table('orgaos')->max('id');
				$input['registro_id'] = $id_registro;
				$log 				  = LoggerUsers::create($input);
				$lastUpdated 		  = $log->max('updated_at');
				$orgaos 	          = Orgaos::all();
				$validator 			  = 'Órgão cadastrado com sucesso!';
				return redirect()->route('listarORG', [$id])
					->withErrors($validator);
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function alterarORG($id_unidade, $id_orgaos, Request $request)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidadesMenu = Unidade::where('status_unidades', 1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades', 1)->find($id_unidade);
		if ($validacao == 'ok') {
			$orgaos = Orgaos::where('id', $id_orgaos)->get();
			if (is_null($orgaos)) {
				return redirect()->route('listarORG', [$id_unidade]);
			} else {
				return view('orgaos/orgaos_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'orgaos'));
			}
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

    public function updateORG($id_unidade, $id_orgaos, Request $request, Orgaos $orgaos)
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id_unidade);
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$orgaos = Orgaos::where('status', 1);
			if (is_null($orgaos)) {
				return  redirect()->route('listarORG', [$id_unidade]);
			} else {
				$input = $request->all();
				$validator = Validator::make($request->all(), [
					'nome' => 'required|max:255'
				]);
				if ($validator->fails()) {
					return view('orgaos/orgaos_alterar', compact('unidades', 'unidadesMenu', 'unidade', 'orgaos'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$input['unidade_id'] = 1;
					$orgaos = Orgaos::find($id_orgaos);
					$orgaos->update($input);
                    $input['unidade_id']  = $id_unidade;
                    $input['user_id']     = Auth::user()->id;
					$input['registro_id'] = $id_orgaos;
					LoggerUsers::create($input);
					$validator = 'Órgão alterado com sucesso!';
					return redirect()->route('listarORG', [$id_unidade])
						->withErrors($validator);
				}
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function telaInativarORG($id_unidade, $id_orgaos, Request $request)
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id_unidade);
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		if ($validacao == 'ok') {
			$orgaos = Orgaos::where('id', $id_orgaos)->get();
			if (is_null($orgaos)) {
				return redirect()->route('listarORG', [$id_unidade]);
			} else {
				return view('orgaos/orgaos_inativar', compact('unidade', 'unidades', 'unidadesMenu', 'orgaos'));
			}
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function inativarORG($id_unidade, $id_orgaos, Request $request)
	{
		$input  = $request->all();
		$orgaos = Orgaos::where('id',$id_orgaos)->get();
		if($orgaos[0]->status == 0) {
			DB::statement('UPDATE orgaos SET status = 1 WHERE id = '.$id_orgaos.';');
		} else {
			DB::statement('UPDATE orgaos SET status = 0 WHERE id = '.$id_orgaos.';');
		}
		$input['registro_id'] = $id_orgaos;
        $input['unidade_id']  = $id_unidade;
        $input['user_id']     = Auth::user()->id;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id_unidade);
		$orgaos       = Orgaos::where('id',$id_orgaos)->paginate(20);
		$validator    = 'Órgão inativado com sucesso!';
		return redirect()->route('listarORG', [$id_unidade])->withErrors($validator);
	}

	public function pesquisaOrgaos($id, Request $request)
    {
        $input = $request->all();
        if(empty($input['funcao2'])) { $input['funcao2'] = ""; }
        if(empty($input['text'])) { $input['text'] = ""; }
        $funcao = $input['funcao2'];
		$nome   = $input['text'];
		if ($funcao == "1") {
			$orgaos = Orgaos::where('nome','LIKE','%'.$nome.'%')->paginate(30);
		}  else {
            $orgaos = Orgaos::paginate(30);
        }
		$unidade  = Unidade::find($id);
        $unidades = Unidade::all();
        $unidadesMenu = Unidade::all();
		return view('orgaos/cadastro_orgaos', compact('unidade', 'unidades', 'unidadesMenu', 'orgaos'));
    }
}