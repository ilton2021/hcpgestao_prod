<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentos;
use App\Models\Orgaos;
use App\Models\Unidade;
use App\Models\Type;
use App\Models\LoggerUsers;
use App\Models\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use DB;

class DocumentosController extends Controller
{
    public function cadastroDocumentalUnidade()
    {
        if(Auth::user()->funcao == 1 || Auth::user()->funcao == 0) {
            $unidades = Unidade::all();
            $unidadesMenu = Unidade::all();
            return view('documentos/cadastroDocumentalUnidade', compact('unidades', 'unidadesMenu'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }

    public function cadastroDocumentalLista($id)
    {
        if (Auth::check()) {
            $unidade = Unidade::where('id', $id)->get();
            $unidades = Unidade::all();
            $unidadesMenu = Unidade::all();
            $documentos = Documentos::where('unidade_id', $id)->paginate(20);
            return view('documentos/cadastroDocumentalLista', compact('unidade', 'unidades', 'unidadesMenu', 'documentos'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }

    public function pesquisaDocumentos($id, Request $request)
    {
        $input = $request->all();
        if(empty($input['funcao'])) { $input['funcao'] = ""; }
        if(empty($input['text'])) { $input['text'] = ""; }
        $funcao = $input['funcao'];
		$nome = $input['text'];
		if ($funcao == "1") {
			$documentos = Documentos::where('unidade_id', $id)->where('tipo_documento','LIKE','%'.$nome.'%')->paginate(10);
		} else if ($funcao == "2") {
			$documentos = Documentos::where('unidade_id', $id)->where('nome','LIKE','%'.$nome.'%')->paginate(10);
		} else if ($funcao == "3") {
			$documentos = Documentos::where('unidade_id', $id)->where('email','LIKE','%'.$nome.'%')->paginate(10);
		} else if ($funcao == "4") {
			$documentos = Documentos::where('unidade_id', $id)->where('orgao','LIKE','%'.$nome.'%')->paginate(10);
		} else {
            $documentos = Documentos::where('unidade_id', $id)->paginate(10);
        }
		$unidade = Unidade::where('id', $id)->get();
        $unidades = Unidade::all();
        $unidadesMenu = Unidade::all();
		return view('documentos/cadastroDocumentalLista', compact('unidade', 'unidades', 'unidadesMenu', 'documentos'));
    }
    
    public function cadastroDocumental($id_und)
    {
        if (Auth::check()) {
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
            $orgaos = Orgaos::orderby('nome')->get();
            return view('documentos/cadastroDocumental', compact('unidade', 'unidadesMenu', 'permissao_users', 'orgaos'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }

    public function storeDOC($id, Request $request)
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id);
        $orgaos       = Orgaos::orderby('nome')->get();
		$input = $request->all();
		$validator = Validator::make($request->all(), [
			'tipo_documento' => 'required|max:255',
            'orgao' => 'required|max:255',
            'nome'  => 'required|max:255',
		    'email' => 'required|max:255',
            'data_inicio' => 'required|date',
            'data_fim'    => 'required|date'
		]);
		if ($validator->fails()) {
			return view('documentos/cadastroDocumental', compact('unidades', 'unidadesMenu', 'unidade', 'orgaos'))
		    		->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
		} else {
			$input['status']      = 0;
            $input['unidade_id']  = $id;
            $anoI = date('Y-m-d', strtotime($input['data_inicio']));
			$anoF = date('Y-m-d', strtotime($input['data_fim'])); 
			if(strtotime($anoF) < strtotime($anoI)) {
                $validator = 'Data Início não pode ser maior que Data Final';
                return view('documentos/cadastroDocumental', compact('unidades', 'unidadesMenu', 'unidade', 'orgaos'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
            }
		    $documentos 	      = Documentos::create($input);
			$id_registro 		  = DB::table('documentos')->max('id');
			$input['registro_id'] = $id_registro;
            $input['user_id']     = 1;
			$log 				  = LoggerUsers::create($input);
		    $documentos 	      = Documentos::all();
			$validator 			  = 'Documento cadastrado com sucesso!';
			return redirect()->route('cadastroDocumentalLista', [$id])
					->withErrors($validator);
		}
	}

    public function alterarStatus($id_und, $id_doc, $id)
    {
        if (Auth::check()) {
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
            $documentos = Documentos::where('id', $id_doc)->get();
            return view('documentos/cadastroDocumentalInativar', compact('unidade', 'unidadesMenu', 'permissao_users', 'documentos', 'id'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }

    public function updateDocStatus($id_und, $id_doc, $id, Request $request)
    { 
        $input = $request->all();
        if ($id == 1) {
            $input['status'] = 1;
            $documentos = Documentos::where('id', $id_doc)->get();
            if($documentos[0]->status == 1) {
                $input['status'] = 0;
            } else {
                $input['status'] = 1;
            }
        } else if ($id == 2) {
            $input['status'] = 2;
        } else {
            $input['status'] = 0;
        }
        $documentos = Documentos::find($id_doc);
		$documentos->update($input);
        $validator = 'Status Alterado do Documento';
        return redirect()->route('cadastroDocumentalLista', [$id_und])
					->withErrors($validator);
    }

    public function cadastroDocumentalAlterar($id_und, $id)
    {
        if (Auth::check()) {
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
            $documentos = Documentos::where('id', $id)->get();
            $orgaos = Orgaos::orderby('nome')->get();
            return view('documentos/cadastroDocumentalAlterar', compact('unidade', 'unidadesMenu', 'permissao_users', 'documentos', 'orgaos'));
        } else {
            $validator = "Você não tem permissão para acessar esta área.";
            return redirect()->back()
                    ->withErrors($validator);
        }
    }

    public function updateDOC($id_und, $id, Request $request)
	{
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade 	  = Unidade::where('status_unidades',1)->find($id_und);
		$documentos = Documentos::where('id', $id)->get();
        $orgaos     = Orgaos::orderby('nome')->get();
        $input = $request->all();
		$validator = Validator::make($request->all(), [
			'tipo_documento' => 'required|max:255',
            'orgao' => 'required|max:255',
            'nome'  => 'required|max:255',
		    'email' => 'required|max:255',
            'data_inicio' => 'required|date',
            'data_fim'    => 'required|date'
		]);
		if ($validator->fails()) {
			return view('documentos/cadastroDocumentalAlterar', compact('unidades', 'unidadesMenu', 'unidade', 'documentos', 'orgaos'))
		    		->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
		} else {
			$input['status']     = 0;
            $input['unidade_id'] = $id_und;
            $anoI = date('Y-m-d', strtotime($input['data_inicio']));
			$anoF = date('Y-m-d', strtotime($input['data_fim'])); 
			if(strtotime($anoF) < strtotime($anoI)) {
                $validator = 'Data Início não pode ser maior que Data Final';
                return view('documentos/cadastroDocumental', compact('unidades', 'unidadesMenu', 'unidade', 'orgaos'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
            }
		    $documentos = Documentos::find($id);
			$documentos->update($input);
			$id_registro 		  = DB::table('documentos')->max('id');
			$input['registro_id'] = $id_registro;
            $input['user_id']     = 1;
			$log 				  = LoggerUsers::create($input);
			$documentos 	      = Documentos::all();
			$validator 			  = 'Documento alterado com sucesso!';
			return redirect()->route('cadastroDocumentalLista', [$id_und])
		    		->withErrors($validator);
		}
	}
}