<?php

namespace App\Http\Controllers;

use App\Models\RegulamentosRh;
use App\Models\LoggerUsers;
use App\Models\Unidade;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Validator;
use DB;

class RegulamentosRhController extends Controller
{
    public function __construct(Unidade $unidade, LoggerUsers $logger_users)
	{
		$this->unidade 			= $unidade;
		$this->logger_users     = $logger_users;
	}
    
    public function index($id){
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id);
		$regulamentoRh = RegulamentosRh::where('unidade_id',$id)->get();
		if($validacao == 'ok') {
			return view('transparencia.regulamentos_rh.regulamentos_rh_index', compact('unidades','unidadesMenu','unidade','id','regulamentoRh'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }
    public function create($id){
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id);
		if($validacao == 'ok') {
			return view('transparencia.regulamentos_rh.regulamentos_rh_create', compact('unidades','unidadesMenu','unidade','id'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
        
    }
    public function store($id, Request $request){
        $validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($id);
		if($validacao == 'ok') {
            $unidadesMenu = Unidade::where('status_unidades',1)->get();
    		$unidades 	  = $unidadesMenu;
    		$unidade      = Unidade::where('status_unidades',1)->find($id);
    		$input 		  = $request->all();
    		$dataHora     = date('YmdHis');
    		$nome 		  = $dataHora . $_FILES['file_path']['name']; 
    		$extensao 	  = pathinfo($nome, PATHINFO_EXTENSION);
    		if($request->file('file_path') === NULL) {	
    			$validator = 'Informe o arquivo do regulamento!';
    			return view('transparencia.regulamentos_rh.regulamentos_rh_create', compact('unidades','unidade','unidadesMenu','id'))
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
    					return view('transparencia.regulamentos_rh.regulamentos_rh_create', compact('unidades','unidade','unidadesMenu','id'))
            				->withErrors($validator)
            				->withInput(session()->flashInput($request->input()));
    				}
    				$request->file('file_path')->move('../public/storage/regulamento_RH/'.$unidade->sigla.'/',$nome);
    				$input['regulamentorh'] = $input['nome'];
    				$input['file_path']  = 'regulamento_RH/'. $unidade->sigla.'/'.$nome;
    				$RegulamentoRh     = RegulamentosRh::create($input);	
    				$id_registro 		  = DB::table('regulamentos_rh')->max('id');
    				$input['registro_id'] = $id_registro;
    				$log 	 		      = LoggerUsers::create($input);
    				$validator 			  = 'Regulamento cadastrado com sucesso!';
    				$sucesso = "ok";
            		 return  redirect()->route('regulamentosRhCadastros', $id)
                        ->withErrors($validator);
    			} else {
    				$validator 	= 'Só suporta arquivos do tipo: PDF!';	
    
    				return view('transparencia.regulamentos_rh.regulamentos_rh_create', compact('unidades','unidade','unidadesMenu','id'))
            				->withErrors($validator)
            				->withInput(session()->flashInput($request->input()));
    			}
    		}
		}else{
		    $validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
    }
    
    public function Edit($id_regulamento,$unidade_id){
        $validacao = permissaoUsersController::Permissao($unidade_id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($unidade_id);
	
		if($validacao == 'ok') {
		    
		    $regulamentoRh = RegulamentosRh::where('id',$id_regulamento)->get();
		    $id = $unidade_id;
            return view('transparencia.regulamentos_rh.regulamentos_rh_edit', compact('unidades','unidadesMenu','unidade','id','regulamentoRh'));
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
        
    }
    
    public function Update($id_regulamento,$unidade_id, Request $request){
        
        $validacao = permissaoUsersController::Permissao($unidade_id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($unidade_id);
		$regulamentoRh = RegulamentosRh::where('id',$id_regulamento)->get();
		$id = $unidade_id;
		if($validacao == 'ok') {
		    $input  = $request->all();
            $validator = Validator::make($request->all(), [
    		    'nome' => 'required|max:255',
    			'mes'  => 'required',
    			'ano'  => 'required'
    	    ]);
    		if ($validator->fails()) {
    		    $failed    = $validator->failed();
    		    $validator = 'Preencha todos os campos corretamente!';
    			return view('transparencia.regulamentos_rh.regulamentos_rh_edit', compact('unidades','unidadesMenu','unidade','id','regulamentoRh'))
            	    ->withErrors($validator)
            		->withInput(session()->flashInput($request->input()));
    		}else{
    		    if(isset($input['file_path'])){
    		        $dataHora     = date('YmdHis');
        		    $nome 		  = $dataHora . $_FILES['file_path']['name']; 
        		    $extensao 	  = pathinfo($nome, PATHINFO_EXTENSION);
    		        $extensao = strtolower($extensao);
    			    if($extensao !== 'pdf') {
        		        $validator = 'Formato do arquivo deve ser PDF';
            			return view('transparencia.regulamentos_rh.regulamentos_rh_edit', compact('unidades','unidadesMenu','unidade','id','regulamentoRh'))
                    	    ->withErrors($validator)
                    		->withInput(session()->flashInput($request->input()));
    			    }else{
        		        $request->file('file_path')->move('../public/storage/regulamento_RH/'.$unidade->sigla.'/',$nome);
    				    $input['file_path']  = 'regulamento_RH/'. $unidade->sigla.'/'.$nome;
    			    }
    		    }
                $input['regulamentorh'] = $input['nome'];
        		$regulamentoRh = RegulamentosRh::find($id_regulamento);
			    $regulamentoRh->update($input);
			    $validator = "Regulamento alterado com sucesso";
			    return  redirect()->route('regulamentosRhCadastros', $unidade_id)
                ->withErrors($validator);
    		}		    
		    
		}else{
		    $validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
        
    }
    
    
    public function status($id_regulamento, $unidade_id){
        $validacao = permissaoUsersController::Permissao($unidade_id);
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade  = Unidade::find($unidade_id);
		if($validacao == 'ok') {
		    $regulamentoRh = RegulamentosRh::find($id_regulamento);
		    $nomeArquivo = explode("/", $regulamentoRh->file_path);
            $nomeArquivo = $nomeArquivo[sizeof($nomeArquivo) - 1];
		    if($regulamentoRh->status_regula_rh == 1){
		        $caminhoOrigem = storage_path('../public/storage/regulamento_RH/'. $unidade->sigla .'/'. $nomeArquivo); // Caminho de origem
                $caminhoDestino = storage_path('../public/storage/regulamento_RH/'. $unidade->sigla .'/lixeira_946468/'. $nomeArquivo); // Caminho de destino
                if (!File::exists(dirname($caminhoDestino))) {
                    File::makeDirectory(dirname($caminhoDestino), 0755, true, true);
                }
                File::move($caminhoOrigem, $caminhoDestino);
                $input['status_regula_rh'] = 0;
                $input['file_path'] = "regulamento_RH/". $unidade->sigla ."/lixeira_946468/". $nomeArquivo;
		        $validator = "Regulamento inativado com sucesso";
		    }else{
		        $caminhoOrigem = storage_path('../public/storage/regulamento_RH/'. $unidade->sigla .'/lixeira_946468/'. $nomeArquivo); // Caminho de origem
                $caminhoDestino = storage_path('../public/storage/regulamento_RH/'. $unidade->sigla .'/'. $nomeArquivo); // Caminho de destino
                File::move($caminhoOrigem, $caminhoDestino);
		        $input['status_regula_rh'] = 1;
		        $input['file_path'] = "regulamento_RH/". $unidade->sigla ."/". $nomeArquivo;
		        $validator = "Regulamento ativado com sucesso";
		    }
			$regulamentoRh->update($input);
			return  redirect()->route('regulamentosRhCadastros', $unidade_id)
                ->withErrors($validator);
		} else {
			$validator = 'Você não tem Permissão!!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
        
    }
    
    

}
