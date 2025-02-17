<?php

namespace App\Http\Controllers;

use App\Models\CertificadoIntegridade;
use App\Models\Unidade;
use App\Models\PermissaoUsers;
use App\Models\LoggerUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use Validator;
use DB;

class CertificadoIntegridadeController extends Controller
{
    public function __construct(Unidade $unidade, CertificadoIntegridade $integridade, LoggerUsers $logger_users)
    {
        $this->unidade 		= $unidade;
		$this->integridade  = $integridade;
		$this->logger_users = $logger_users;
    }
	
    public function index()
    {
		$unidades = Unidade::all();
		return view ('transparencia', compact('unidades'));
    }

    public function cadastroCI($id)
	{
		$validacao 	  = permissaoUsersController::Permissao($id);
		$unidade      = Unidade::find($id);
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$integridade  = CertificadoIntegridade::all();
        $lastUpdated  = $integridade->max('updated_at');
		if($validacao == 'ok') {
			return view('transparencia/integridade/integridade_cadastro', compact('unidade','unidades','unidadesMenu','integridade','lastUpdated'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator);
		}
	}
	
	public function novoCI($id)
	{
		$validacao    = permissaoUsersController::Permissao($id);
		$unidade      = Unidade::find($id);
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		if($validacao == 'ok') {
			return view('transparencia/integridade/integridade_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
	public function excluirCI($id_unidade, $id_item)
	{
		$validacao    = permissaoUsersController::Permissao($id_unidade);
		$unidade      = Unidade::find($id_unidade);
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$integridade  = CertificadoIntegridade::where('status_integridade',1)->where('id',$id_item)->get();
		$lastUpdated  = $integridade->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/integridade/integridade_excluir', compact('unidade','unidades','unidadesMenu','integridade','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function telaInativarCI($id_unidade, $id_item)
	{
		$validacao 	  = permissaoUsersController::Permissao($id_unidade);
		$unidade      = Unidade::find($id_unidade);
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$integridade  = CertificadoIntegridade::where('id',$id_item)->get();
		$lastUpdated  = $integridade->max('updated_at');	
		if($validacao == 'ok') {
			return view('transparencia/integridade/integridade_excluir', compact('unidade','unidades','unidadesMenu','integridade','lastUpdated'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}
	
    public function storeCI($id_unidade, Request $request)
    { 
        $unidade      = Unidade::find($id_unidade);
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
        $lastUpdated  = date('d-m-Y', strtotime('now'));
		$input 		  = $request->all();
		$nome 		  = $_FILES['path_file']['name']; 
		$extensao     = pathinfo($nome, PATHINFO_EXTENSION);
		if($request->file('path_file') === NULL) {	
			$validator = 'Informe o arquivo do Certificado de Integridade!';
			return view('transparencia/integridade/integridade_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		} else {
			if ($extensao == 'pdf' || $extensao == 'PDF') {
				$validator  = Validator::make($request->all(), [
					'name' => 'required|max:255'
				]);
				if ($validator->fails()) {
					return view('transparencia/integridade/integridade_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));	
				} else {  
					$nomeA = $_FILES['path_file']['name'];   
					$request->file('path_file')->move('../public/storage/integridade', $nomeA);
					$input['path_file'] = 'integridade/' .$nomeA;
					$input['status_integridade'] = 1;	
					$integridade = CertificadoIntegridade::create($input);	
					$id_registro = DB::table('integridade')->max('id');
					$input['registro_id'] = $id_registro;
					$input['unidade_id']  = 1;
					$log         = LoggerUsers::create($input);
					$lastUpdated = $log->max('updated_at');
					$integridade = CertificadoIntegridade::where('status_integridade',1)->get();
					$validator   = 'Certificado de Integridade cadastrado com sucesso!';
					return redirect()->route('cadastroCI',[$id_unidade])->withErrors($validator);
                }
			} else {	
				$validator = 'Só suporta arquivos do tipo: .pdf!';
				$integridade = CertificadoIntegridade::all();
				$lastUpdated = $integridade->max('updated_at');
				return view('transparencia/integridade/integridade_novo', compact('unidades','unidade','unidadesMenu','lastUpdated'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));	
			}
		}
	}

    public function destroyCI($id_unidade, $id_item, CertificadoIntegridade $integridade, Request $request)
    {
		$input   	  = $request->all();
		$integridade  = CertificadoIntegridade::where('id',$id_item)->get();
		$image_path   = 'storage/'.$integridade[0]->path_file;
        unlink($image_path);
		CertificadoIntegridade::find($id_item)->delete();		
		$input['registro_id'] = $id_item;
		$input['unidade_id']  = 1;
		$log   		  = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidade      = Unidade::find($id_unidade);
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;	
		$integridade  = CertificadoIntegridade::where('status_integridade', 1)->get();
		$validator 	  = 'Certificado de Integridade Excluído com sucesso!';
		return redirect()->route('cadastroCI', [$id_unidade])
			 ->withErrors($validator);
    }

	public function inativarCI($id, $id_item, Request $request)
    {
		$input = $request->all();
		$integridade = CertificadoIntegridade::where('id',$id_item)->get();
		if($integridade[0]->status_integridade == 1) {
			$nomeArq    = explode("integridade/", $integridade[0]->path_file); 
			$nome       = "old_". $nomeArq[1]; 
			$image_path = 'integridade/'.$nome;  
			DB::statement("UPDATE integridade SET `status_integridade` = 0, `path_file` = '$image_path' WHERE `id` = $id_item");
			$image_path = 'storage/integridade/'.$nome; 
			$caminho    = 'storage/'.$integridade[0]->path_file;  
			rename($caminho, $image_path);
		} else {
			$nomeArq    = explode("integridade/old_", $integridade[0]->path_file);
			$image_path = 'integridade/'.$nomeArq[1];
			DB::statement("UPDATE integridade SET `status_integridade` = 1, `path_file` = '$image_path' WHERE `id` = $id_item");
			$image_path = 'storage/integridade/'.$nomeArq[1];
			$caminho    = 'storage/'.$integridade[0]->path_file;
			rename($caminho, $image_path);		
		}
		$input['registro_id'] = $integridade[0]->id;
		$input['unidade_id']  = 1;
		$log          = LoggerUsers::create($input);
		$lastUpdated  = $log->max('updated_at');
        $unidadesMenu = Unidade::where('status_unidades',1)->get();
		$unidades 	  = $unidadesMenu;
		$unidade      = Unidade::where('status_unidades',1)->find($id);
		$integridade  = CertificadoIntegridade::where('id',$id_item)->get();
		$validator    = 'Certificado de Integridade inativado com sucesso!';
		return redirect()->route('cadastroCI', [$id])
				->withErrors($validator);
    }
}