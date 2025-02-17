<?php

namespace App\Http\Controllers;

use App\Models\RegulamentosContratos;
use App\Models\LoggerUsers;
use App\Models\Unidade;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;

class RegulamentosContratosController extends Controller
{
    public function __construct(Unidade $unidade, LoggerUsers $logger_users)
	{
		$this->unidade 			= $unidade;
		$this->logger_users     = $logger_users;
	}

    public function index()
    {
		$unidades = Unidade::all();
		return view ('transparencia', compact('unidades'));
    }
	
    public function regulamentosContratosCadastro($id, Request $request)
    {
        $validacao 	  = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id);	
		$regulamentos = RegulamentosContratos::all();
        $lastUpdated  = $regulamentos->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/regulamentos_contratos/regulamentos_cadastro', compact('unidade','unidades','unidadesMenu','regulamentos','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));	
		}
    }

    public function novoRC($id, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id);
		if($validacao == 'ok') {
			return view('transparencia/regulamentos_contratos/regulamentos_novo', compact('unidades','unidadesMenu','unidade','id'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function storeRC($id, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::where('status_unidades',1)->get();
    	$unidades 	  = $unidadesMenu;
    	$unidade      = Unidade::where('status_unidades',1)->find($id);
		if($validacao == 'ok') {
    		$input 	  = $request->all();
    		$nome 	  = $_FILES['file_path']['name']; 
    		$extensao = pathinfo($nome, PATHINFO_EXTENSION);
    		if($request->file('file_path') === NULL) {	
    			$validator = 'Informe o arquivo do Regulamento!';
    			return view('transparencia/regulamentos_contratos/regulamentos_novo', compact('unidades','unidade','unidadesMenu'))
    				->withErrors($validator)
    				->withInput(session()->flashInput($request->input()));
    		} else {
    		    $extensao = strtolower($extensao);
    			if($extensao === 'pdf') {
    				$validator = Validator::make($request->all(), [
    					'title' => 'required|max:255',
                        'tipo'  => 'required|max:255'
    				]);
    				if ($validator->fails()) {
    					return view('transparencia/regulamentos_contratos/regulamentos_novo', compact('unidades','unidade','unidadesMenu'))
            				->withErrors($validator)
            				->withInput(session()->flashInput($request->input()));
    				}
    				$request->file('file_path')->move('../public/storage/regulamento_contratos/',$nome);
    				$input['name_arq'] = $nome;
    				$input['caminho']  = 'regulamento_contratos/'.$nome;
                    $input['status']   = 1;
    				$regulamentos      = RegulamentosContratos::create($input);	
    				$id_registro 		  = DB::table('regulamentos_contratos')->max('id');
    				$input['registro_id'] = $id_registro;
    				$log 	 		      = LoggerUsers::create($input);
    				$validator 			  = 'Regulamento de Contrato cadastrado com sucesso!';
    				return redirect()->route('regulamentosContratosCadastro', $id)
                        ->withErrors($validator);
    			} else {
    				$validator 	= 'Só suporta arquivos do tipo: PDF!';	
    				return view('transparencia/regulamentos_contratos/regulamentos_novo', compact('unidades','unidade','unidadesMenu'))
            				->withErrors($validator)
            				->withInput(session()->flashInput($request->input()));
    			}
    		}
		} else{
		    $validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }

    public function telaInativarRC($id, $idR)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id);
        $regulamentos = RegulamentosContratos::where('id',$idR)->get();
		if($validacao == 'ok') {
			return view('transparencia/regulamentos_contratos/regulamentos_inativar', compact('unidades','unidadesMenu','unidade','regulamentos'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    } 

    public function inativarRC($id, $idR, Request $request)
    {
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id);
		if($validacao == 'ok') {
		    $regulamentos = RegulamentosContratos::find($idR);
		    $nomeArquivo = explode("/", $regulamentos->caminho);
            $nomeArquivo = $nomeArquivo[sizeof($nomeArquivo) - 1];
		    if($regulamentos->status == 1){
		        $caminhoOrigem = storage_path('../public/storage/regulamento_contratos/'. $nomeArquivo); // Caminho de origem
                $caminhoDestino = storage_path('../public/storage/regulamento_contratos/lixeira_946468/'. $nomeArquivo); // Caminho de destino
                if (!File::exists(dirname($caminhoDestino))) {
                    File::makeDirectory(dirname($caminhoDestino), 0755, true, true);
                }
                File::move($caminhoOrigem, $caminhoDestino);
                $input['status'] = 0;
                $input['caminho'] = "regulamento_contratos/lixeira_946468/". $nomeArquivo;
		        $validator = "Regulamento Contratos inativado com sucesso";
		    }else{
		        $caminhoOrigem = storage_path('../public/storage/regulamento_contratos/lixeira_946468/'. $nomeArquivo); // Caminho de origem
                $caminhoDestino = storage_path('../public/storage/regulamento_contratos/'. $nomeArquivo); // Caminho de destino
                File::move($caminhoOrigem, $caminhoDestino);
		        $input['status'] = 1;
		        $input['caminho'] = "regulamento_contratos/". $nomeArquivo;
		        $validator = "Regulamento Contratos ativado com sucesso";
		    }
			$regulamentos->update($input);
			return  redirect()->route('regulamentosContratosCadastro', $id)
                ->withErrors($validator);
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }
}
