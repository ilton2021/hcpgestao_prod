<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Institucional;
use App\Models\LoggerUsers;
use App\Models\UnidadesCapacity;
use App\Models\UnidadesSpecialty;
use App\Models\PermissaoUsers;
use App\Http\Controllers\PermissaoUsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class InstitucionalController extends Controller
{
	protected $unidade;
	
    public function __construct(Unidade $unidade, LoggerUsers $logger_users)
    {
		$this->unidade 		= $unidade;
		$this->logger_users = $logger_users;
    }

    public function index()
    {
		$unidades = Unidade::all();
        return view('home', compact('unidades'));
    }
	
	public function institucionalCadastro($id, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);

		$unidadesMenu = Unidade::all();
		$unidades = Unidade::all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function institucionalNovo($id, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = Unidade::all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem Permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));		
		}
	}

	public function store($id, Request $request)
	{	
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade = $unidadesMenu->find($id);
		$input = $request->all();	
		$nome = $_FILES['path_img']['name']; 		
		$extensao = pathinfo($nome, PATHINFO_EXTENSION);		
		$nomeI = $_FILES['icon_img']['name']; 		
		$extensaoI = pathinfo($nomeI, PATHINFO_EXTENSION);
		if(($request->file('path_img') === NULL) || ($request->file('icon_img') === NULL)) {	
			$validator = 'Insira um arquivo e um ícone!';
			return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu','true'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		} else {
			if(($extensao == 'png' || $extensao == 'jpg') && ($extensaoI == 'png' || $extensaoI == 'jpg')) {
				$validator = Validator::make($request->all(), [
					'owner'       => 'required|max:255',
					'cnpj'        => 'required|max:18',
					'telefone'    => 'required|max:13',
					'cep' 	   	  => 'required|max:11',
					'google_maps' => 'required'
				]);
				if ($validator->fails()) {
					return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				} else {
					$nome = $_FILES['path_img']['name']; 
					$input['path_img'] = $nome; 
					$nomeI = $_FILES['icon_img']['name'];
					$input['icon_img'] = $nomeI;
					$request->file('path_img')->move('../public/img', $nome);	
					$request->file('icon_img')->move('../public/img', $nomeI);	
					$unidade = Unidade::create($input);
					$log = LoggerUsers::create($input);	
					$lastUpdated = $log->max('updated_at');	
					$validator = 'Instituição Cadastrada com Sucesso!';
					return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated'))
						->withErrors($validator)
						->withInput(session()->flashInput($request->input()));
				}
			} else  {	
				$validator = 'Só são suportados arquivos do tipo: JPG ou PNG!';
				return view('transparencia/institucional/institucional_novo', compact('unidade','unidades','unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
		}		
	}

	public function institucionalAlterar($id, Request $request)
	{
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = Unidade::all();
		$unidade = $unidadesMenu->find($id);
		if ($validacao == 'ok') {
			$Capacity = UnidadesCapacity::where('unidade_id', $unidade->id)->where('status_capacity', 1)->get();
			$Capacity_desc = UnidadesCapacity::selectRaw('MIN(id) AS id, descricao')
				->where('unidade_id', $unidade->id)
				->groupBy('descricao')
				->orderBy('id', 'asc')
				->get();
			$specialty = UnidadesSpecialty::where('unidade_id', $unidade->id)->where('status_specialty', 1)->get();
			$specialty_desc = UnidadesSpecialty::selectRaw('MIN(id) AS id, description')
				->where('unidade_id', $unidade->id)
				->groupBy('description')
				->orderBy('id', 'asc')
				->get();

			return view('transparencia/institucional/institucional_alterar', compact('unidade', 'unidades', 'unidadesMenu', 'Capacity', 'Capacity_desc', 'specialty', 'specialty_desc'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades', 'unidade', 'unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input()));
		}
	}

	public function update($id, Request $request)
	{
		$unidadesMenu = Unidade::all();
		$unidades = $unidadesMenu;
		$unidade = $unidadesMenu->find($id);
		$input = $request->all();
		$input['unidade_id'] = $id;
		if (($request->file('path_img') === NULL) || ($request->file('icon_img') === NULL)) {
			$validator = Validator::make($request->all(), [
				'owner'    => 'required|max:255',
				'cnpj'     => 'required|max:18',
				'telefone' => 'required|max:13',
				'cep' 	   => 'required|max:10'
			]);
			if ($validator->fails()) {
				return view('transparencia/institucional/institucional_alterar', compact('unidade', 'unidades', 'unidadesMenu'))
					->withErrors($validator)
					->withInput(session()->flashInput($request->input()));
			}
			if (!empty($input['path_img']) && !empty($input['icon_img'])) {
				$input['registro_id'] = $id;
				$unidade = Unidade::find($id);
				$unidade->update($input);
				$log = LoggerUsers::create($input);
				$lastUpdated = $log->max('updated_at');
				//Store e Update de Capacidades
				$ultimoIdC = UnidadesCapacity::all()->max('id') + 1;
				for ($i = 1; $i <= $input['cont_capacidade']; $i++) {
					if (isset($input['inativar_lista_' . $i][0])  && isset($input['unidades_capacity_' . $i]) == false) {
						//inativação de capacidades
						$capacidade = UnidadesCapacity::where('id', $input['inativar_lista_' . $i][0])->get();
						$capacidade = UnidadesCapacity::where('descricao', $capacidade[0]->descricao)->get();
						foreach ($capacidade as $c) {
							$UnidadesCapacity = UnidadesCapacity::find($c->id);
							$UnidadesCapacity->update(['status_capacity' => 0]);
							$input['tela'] = "institucional";
							$input['acao'] = "InativarCapacidadesInstitucionais";
							$input['user_id'] = Auth::user()->id;
							$input['registro_id'] = $c->id;
							$log = LoggerUsers::create($input);
						}
					} else {
						if (isset($input['quantidade_' . $i])) {
							for ($j = 0; $j < sizeof($input['quantidade_' . $i]); $j++) {
								$input['descricao'] = $input['desc_lista_' . $i][0];
								$input['descricao'] = $input['desc_lista_' . $i][0] == "" ? "SEM_DESC_" . $ultimoIdC : $input['desc_lista_' . $i][0];
								$id_capacidade = $input['unidades_capacity_' . $i][$j];
								$input['quantidades'] = $input['quantidade_' . $i][$j];
								$input['desc_quantidades'] =  $input['desc_local_' . $i][$j];
								//Verificação de se é uma nova capacidade
								if ($id_capacidade == "") {
									//Criação de nova especialidade
									if ($input['desc_quantidades'] !== NULL) {
										$und_capacity = UnidadesCapacity::create($input);
										$id_reg = UnidadesCapacity::all()->max('id');
										$input['tela'] = "institucional";
										$input['acao'] = "SalvarCapacidadesInstitucionais";
										$input['user_id'] = Auth::user()->id;
										$input['registro_id'] = $id_reg;
										$log = LoggerUsers::create($input);
									}
								} else {
									$und_capacity = UnidadesCapacity::where('id', $id_capacidade)->get();
									//Verificação de alteração de capacidade
									if (
										$und_capacity[0]->quantidades 		  !=  $input['quantidades']
										|| $und_capacity[0]->desc_quantidades !== $input['desc_quantidades']
										|| $und_capacity[0]->descricao        !== $input['descricao']
									) {
										//Registro de estado da capacidade antes da alteração
										$und_capacity = UnidadesCapacity::create(
											[
												'descricao' => $und_capacity[0]->descricao,
												'quantidades' => $und_capacity[0]->quantidades,
												'desc_quantidades' => $und_capacity[0]->desc_quantidades,
												'status_capacity' => 0,
												'unidade_id' => $und_capacity[0]->unidade_id,
											]
										);
										$id_reg = UnidadesCapacity::all()->max('id');
										$input['tela'] = "institucional";
										$input['acao'] = "SalvarAlteraçãoCapacidadesInstitucionais";
										$input['user_id'] = Auth::user()->id;
										$input['registro_id'] = $id_reg;
										$log = LoggerUsers::create($input);
										//atualização da capacidade
										$UnidadesCapacity = UnidadesCapacity::find($id_capacidade);
										$UnidadesCapacity->update($input);
										$input['tela'] = "institucional";
										$input['acao'] = "AtualizarCapacidadesInstitucionais";
										$input['user_id'] = Auth::user()->id;
										$input['registro_id'] = $id_capacidade;
										$log = LoggerUsers::create($input);
									}
								}
							}
						}
						//Inativação de itens da lista de capacidades
						if (isset($input['inativar_item_' . $i])) {
							foreach ($input['inativar_item_' . $i] as $itens) {
								$UnidadesCapacity = UnidadesCapacity::find($itens);
								$UnidadesCapacity->update(['status_capacity' => 0]);
								$input['tela'] = "institucional";
								$input['acao'] = "InativarCapacidadesInstitucionais";
								$input['user_id'] = Auth::user()->id;
								$input['registro_id'] = $itens;
								$log = LoggerUsers::create($input);
							}
						}
					}
				}
				$ultimoId = UnidadesSpecialty::all()->max('id') + 1;
				//Store e Update de Especialidades
				for ($i = 1; $i <= $input['cont_especialidade']; $i++) {
					if (isset($input['inativar_lista_esp_' . $i][0])  && isset($input['unidades_especialidade_' . $i]) == false) {
						//Inativação de lista de especialidades.
						$especialidade = UnidadesSpecialty::where('id', $input['inativar_lista_esp_' . $i][0])->get();
						$especialidade = UnidadesSpecialty::where('description', $especialidade[0]->description)->get();
						foreach ($especialidade as $e) {
							$UnidadesEspecialidade = UnidadesSpecialty::find($e->id);
							$UnidadesEspecialidade->update(['status_specialty' => 0]);
							$input['tela'] = "institucional";
							$input['acao'] = "InativarEspecialidadeInstitucionais";
							$input['user_id'] = Auth::user()->id;
							$input['registro_id'] = $e->id;
							$log = LoggerUsers::create($input);
						}
					} else {
						if (isset($input['desc_esp_' . $i]) && $input['desc_esp_' . $i] !== NULL) {
							for ($j = 0; $j < sizeof($input['desc_esp_' . $i]); $j++) {
								$input['description'] = $input['desc_lista_esp_' . $i][0] == "" ? "SEM_DESC_" . $ultimoId : $input['desc_lista_esp_' . $i][0];
								$id_especialidade = $input['unidades_especialidade_' . $i][$j];
								$input['specialty'] = $input['desc_esp_' . $i][$j];
								//Verificação de é uma nova especialidade
								if ($id_especialidade == "") {
									if ($input['specialty'] !== NULL) {
										//Criação de nova especialidade
										$und_especialidade = UnidadesSpecialty::create($input);
										$id_reg = UnidadesSpecialty::all()->max('id');
										$input['tela'] = "institucional";
										$input['acao'] = "SalvarEspecialidadeInstitucionais";
										$input['user_id'] = Auth::user()->id;
										$input['registro_id'] = $id_reg;
										$log = LoggerUsers::create($input);
									}
								} else {
									$und_especialidade = UnidadesSpecialty::where('id', $id_especialidade)->get();
									//Verificação de alteração de especialidades
									if (
										$und_especialidade[0]->specialty      != $input['specialty']
										|| $und_especialidade[0]->description != $input['description']
									) {
										$und_especialidade = UnidadesSpecialty::create(
											[
												'description'      => $und_especialidade[0]->description,
												'specialty'   	   => $und_especialidade[0]->specialty,
												'unidade_id'   	   => $und_especialidade[0]->unidade_id,
												'status_specialty' => 0
											]
										);
										//Criação de historico de especialidade
										$id_reg = UnidadesSpecialty::all()->max('id');
										$input['tela'] = "institucional";
										$input['acao'] = "SalvarAlteraçãoEspecialidadesInstitucionais";
										$input['user_id'] = Auth::user()->id;
										$input['registro_id'] = $id_reg;
										$log = LoggerUsers::create($input);
										//Atualuização de especialidades
										$und_especialidade = UnidadesSpecialty::find($id_especialidade);
										$und_especialidade->update($input);
										$input['tela'] = "institucional";
										$input['acao'] = "AlterarEspecialidadeInstitucionais";
										$input['user_id'] = Auth::user()->id;
										$input['registro_id'] = $id_especialidade;
										$log = LoggerUsers::create($input);
									}
								}
							}
						}
						//Inativação de especialidades
						if (isset($input['inativar_item_esp_' . $i])) {
							foreach ($input['inativar_item_esp_' . $i] as $itens) {
								$UnidadesEspecialidade = UnidadesSpecialty::find($itens);
								$UnidadesEspecialidade->update(['status_specialty' => 0]);
								$input['tela'] = "institucional";
								$input['acao'] = "InativarEspecialidadeInstitucionais";
								$input['user_id'] = Auth::user()->id;
								$input['registro_id'] = $itens;
								$log = LoggerUsers::create($input);
							}
						}
					}
				}
				$validator = 'Instituição Alterada com Sucesso!';
				return  redirect()->route('transparenciaHome', $id)
					->withErrors($validator);
			}
		} else {
			$unidade = Unidade::find($id);
			$unidade->update($input);
			$lastUpdated = $unidade->max('updated_at');
			LoggerUsers::create($input);
			$validator = 'Instituição Alterada com Sucesso!';
			return  redirect()->route('transparenciaHome', $id)
				->withErrors($validator);
		}
	}

	public function institucionalExcluir($id, Request $request)
	{ 
		$validacao = permissaoUsersController::Permissao($id);
		$unidadesMenu = Unidade::all();
		$unidades = Unidade::all();
		$unidade = $unidadesMenu->find($id);
		if($validacao == 'ok') {
			return view('transparencia/institucional/institucional_excluir', compact('unidade','unidades','unidadesMenu'));
		} else {
			$validator = 'Você não tem permissão!';
			return view('home', compact('unidades','unidade','unidadesMenu'))
				->withErrors($validator)
				->withInput(session()->flashInput($request->input())); 		
		}
	}

	public function destroy($id, Unidade $unidade, Request $request)
	{ 
		$input = $request->all();
		$logers = LoggerUsers::where('unidade_id', $input['unidade_id'])->get();
		$qtdLog = sizeof($logers);
		if($qtdLog > 0) {
			for ( $i = 0; $i <= $qtdLog; $i++ ) {
				LoggerUsers::find($logers[$i]['id'])->delete();	
			}
		}		
		Unidade::find($id)->delete();		
		$unidadesMenu = Unidade::all();
		$unidades = Unidade::all();
		$lastUpdated = $unidades->max('updated_at');	
		$unidade = $unidadesMenu->find(1);
		$validator = 'Instituição Excluída com sucesso!';
		return view('transparencia/institucional/institucional_cadastro', compact('unidade','unidades','unidadesMenu','lastUpdated'))
			->withErrors($validator)
			->withInput(session()->flashInput($request->input()));
	}
}