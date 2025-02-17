<?php

namespace App\Http\Controllers;

use App\Models\ContratacaoServicos;
use App\Models\ContratacaoServicosErratas;
use App\Models\Unidade;
use App\Models\Especialidades;
use App\Models\EspecialidadeContratacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\If_;
use Symfony\Component\VarDumper\VarDumper;
use Validator;
use DateTime;
use DB;

class ContratacaoServicosController extends Controller
{
    public function paginaContratacaoServicos($id_und)
    {
        $unidades     = Unidade::all();
        $unidadesMenu = $unidades;
        $unidade      = $unidadesMenu->find($id_und);
        $sucesso      = "";
        $contratacao_servicos = DB::table('contratacao_servicos')->where('unidade_id', $id_und)->where('status',1)->get();
        return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'unidade', 'unidades', 'sucesso', 'unidadesMenu', 'id_und'));
    }

    public function novaContratacaoServicos($id_und)
    {
        $sucesso        = "";
        $Unidades       = Unidade::all();
        $unidadesMenu   = $Unidades;
        $unidade        = Unidade::find($id_und);
        $especialidades = Especialidades::all();
        return view('contratacao_servicos/contratacaoServicos_novo', compact('Unidades', 'unidadesMenu', 'unidade', 'especialidades', 'sucesso', 'id_und'));
    }

    public function salvarContratacaoServicos($id_und, Request $request)
    {
        $sucesso                   = "";
        $Unidades                  = Unidade::all();
        $contratacao_servicos      = ContratacaoServicos::where('status',1)->get();
        $especialidades            = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::all();
        $input = $request->all();
        $input['status'] = 1;
        $unidadesMenu = Unidade::all();
        $unidade = $unidadesMenu->find($id_und);
        //Veriicando tipo de prazo.
        if ((isset($input['tipoPrazo']) == false)) {
            $input['tipoPrazo']  = 0;
            $input['prazoFinal'] = null;
        }
        //Vericação de inputs
        $validator = Validator::make($request->all(), [
            'texto'        => 'required|max:1000',
            'nome_arq'     => 'required|max:20000',
            'unidade_id'   => 'required|max:255',
            'prazoInicial' => 'required'
        ]);
        $unidade_id = $input['unidade_id'];
        $nome       = $_FILES['nome_arq']['name'];
        $dtPrazoIni = $input['prazoInicial'];
        $extensao   = pathinfo($nome, PATHINFO_EXTENSION);
        if ((isset($dtPrazoFim))) {
            if ($dtPrazoIni >= $dtPrazoFim) {
                $sucesso   = "no";
                $validator = 'A data inicial do prazo não pode ser maior ou igual que a data final ! ';
                return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade', 'unidadesMenu', 'id_und'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        }
        //Verificação de escolha de tipo de contratacao
        if ($input['tipoContrata'] == 2) {
            //Verificação de escolha de especialidade
            if (isset($input['especialidade'])) {
                $count       = sizeof($input['especialidade']);
                $qtdEspSelec = array();
                $qtdEspSelec = $input['especialidade'];
            } else {
                $validator = "Selecione alguma Especialidade!";
                return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade', 'unidadesMenu', 'id_und'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            }
        } else {
            $qtdEspSelec = array();
        }
        if ($validator->fails()) {
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade', 'unidadesMenu', 'id_und'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ((sizeof($qtdEspSelec)) == 0 && $input['tipoContrata'] == 2) {
            $sucesso = "no";
            $validator = 'Escolha pelo menos um especialidade !';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade', 'unidadesMenu', 'id_und'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($request->file('nome_arq') === NULL) {
            $sucesso = "no";
            $validator = 'Você esqueceu de anexar o arquivo!';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade', 'unidadesMenu', 'id_und'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($extensao === 'pdf') {
            $nome = $_FILES['nome_arq']['name'];
            $request->file('nome_arq')->move('../public/storage/contratacao_servicos/', $nome);
            $input['arquivo']  = 'contratacao_servicos/' . $nome;
            $input['nome_arq'] = $nome;
            $input['prazoProrroga'] = null;
            $contratacao_servicos   = ContratacaoServicos::create($input);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');
            if ($input['tipoContrata'] == 2) {
                foreach ($qtdEspSelec as $qtdEsp) {
                    $input['contratacao_servicos_id'] =  $id_contratacao_servico;
                    $input['especialidades_id'] = $qtdEsp;
                    $especialidade_contratacao  = EspecialidadeContratacao::all();
                    $especialidade_contratacao  = EspecialidadeContratacao::create($input);
                }
            }
            $contratacao_servicos = ContratacaoServicos::where('id',$id_contratacao_servico)->get();
            $sucesso   = "ok";
            $validator = 'Contratação de serviço cadastrada sucesso!';
            return redirect()->route('novaContratacaoServicos', $id_und)
                    ->withErrors($validator)
                    ->with('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'validator', 'unidade', 'unidadesMenu', 'id_und');
        } else {
            $sucesso   = "no";
            $validator = 'Só são permitidos os arquivos do tipo: PDF';
            return view('contratacao_servicos/contratacaoServicos_novo', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade', 'unidadesMenu', 'id_und'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        }
    }
    
     //Pesquisar contratação
    public function pesquisarContratacao($id_und, Request $request)
    {
        $sucesso  = "";
        $hoje     = date('Y-m-d');
        $input    = $request->all();
        $unidades = Unidade::all();
        $unidadesMenu = Unidade::all();
        $unidade  = $unidadesMenu->find($id_und);
        $contratacao_servicos = ContratacaoServicos::where('unidade_id', $id_und)->where('status',1)->get();
        if ($input['filtro'] == "selecione") {
            return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
        } elseif ($input['filtro'] == "titulo") {
            if (isset($input['titulo']) == false) {
                $validator = "Processo de contratação não localizada";
                $contratacao_servicos = ContratacaoServicos::where('titulo', 'like', '%' . $input['titulo'] . '%')->where('unidade_id', $id_und)->where('status',1)->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
            } else {
                $contratacao_servicos = ContratacaoServicos::where('titulo', 'like', '%' . $input['titulo'] . '%')->where('unidade_id', $id_und)->where('status',1)->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            }
        } elseif ($input['filtro'] == "tipo") {
            if ($input['tipocontrato'] == "0") {
                $contratacao_servicos = ContratacaoServicos::where('status',1);
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'))
                        ->withInput(session()->flashInput($request->input()));
            } else {
                $contratacao_servicos = ContratacaoServicos::where('tipoContrata', $input['tipocontrato'])->where('unidade_id', $id_und)->where('status',1)->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            }
        } elseif ($input['filtro'] == "data") {
            if (isset($input['dtini']) == false) {
                $validator = "Digite uma data de inicio";
                $contratacao_servicos = ContratacaoServicos::where('unidade_id', $id_und)->where('status',1)->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
            } elseif (isset($input['dtfim']) == true) {
                if ($input['dtini'] > $input['dtfim']) {
                    $validator = "A data inicial precisa ser menor ou igual a final";
                    $contratacao_servicos = ContratacaoServicos::where('unidade_id', $id_und)->where('status',1)->get();
                    return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'))
                            ->withErrors($validator)
                            ->withInput(session()->flashInput($request->input()));
                } else {
                    $where = '((contratacao_servicos.unidade_id = "' . $id_und . '" and  contratacao_servicos.status = 1 )
                    and ((contratacao_servicos.prazoInicial  >= "' . $input['dtini'] . '" and contratacao_servicos.prazofinal  <= "' . $input['dtfim'] . '")
                    or(contratacao_servicos.prazoProrroga  <= "' . $input['dtfim'] . '")))';
                    $contratacao_servicos = DB::table('contratacao_servicos')
                        ->whereRaw($where)
                        ->get();
                    return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
                }
            } else {
                $contratacao_servicos = DB::table('contratacao_servicos')
                    ->where('unidade_id', $id_und)
                    ->where('status',1)
                    ->whereRaw('contratacao_servicos.prazoInicial  >= "' . $input['dtini'] . '"')
                    ->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            }
        } elseif ($input['filtro'] == "status") {
            if ($input['status'] == 0) {
                $validator = "Escolha um status";
                $contratacao_servicos = ContratacaoServicos::where('unidade_id', $id_und)->where('status',1)->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
            } elseif ($input['status'] == 1) {
                //em breve
                $where = '(contratacao_servicos.unidade_id = "' . $id_und . '" and contratacao_servicos.status = 1 and 
                ((contratacao_servicos.prazoInicial  > "' . $hoje  . '" and contratacao_servicos.prazofinal  > "' . $hoje  . '")
                or(contratacao_servicos.prazoInicial  > "' . $hoje  . '" and contratacao_servicos.prazofinal is null)))';

                $contratacao_servicos = DB::table('contratacao_servicos')
                    ->whereRaw($where)
                    ->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            } elseif ($input['status'] == 2) {
                //divulgando
                $where = '(contratacao_servicos.unidade_id = "' . $id_und . '" and contratacao_servicos.status = 1
                and ((contratacao_servicos.prazoInicial  <= "' . $hoje  . '" and contratacao_servicos.prazofinal >= "' . $hoje  . '") 
                or (contratacao_servicos.prazoInicial  <= "' . $hoje  . '" and contratacao_servicos.prazofinal is null and contratacao_servicos.prazoProrroga is null)))';
                $contratacao_servicos = DB::table('contratacao_servicos')
                    ->whereRaw($where)
                    ->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            } elseif ($input['status'] == 3) {
                // Prorrogado;
                $contratacao_servicos = DB::table('contratacao_servicos')
                    ->where('unidade_id', $id_und)
                    ->where('status',1)
                    ->whereRaw('(contratacao_servicos.prazoInicial  <= "' . $hoje  . '"')
                    ->whereRaw('contratacao_servicos.prazoProrroga  >= "' . $hoje  . '")')
                    ->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            } elseif ($input['status'] == 4) {
                //Finalizado;
                $where = '(contratacao_servicos.unidade_id = "' . $id_und . '" and contratacao_servicos.status = 1) 
                and ((contratacao_servicos.prazoInicial  < "' . $hoje  . '" and contratacao_servicos.prazofinal  < "' . $hoje  . '")
                and (contratacao_servicos.prazoProrroga  < "' . $hoje  . '" or contratacao_servicos.prazoProrroga is null))';
                $contratacao_servicos = DB::table('contratacao_servicos')
                    ->whereRaw($where)
                    ->get();
                return view('contratacao_servicos/contratacaoServicos_listagem', compact('contratacao_servicos', 'sucesso', 'unidades', 'id_und', 'unidadesMenu', 'unidade'));
            }
        }
    }
    
    //Pagina exclusão contratação
    public function pagExcluirContratacao($id, $id_und)
    {
        $sucesso = "";
        $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades   = Unidade::where('id', $unidade_id)->get();
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
        $esp_contrata = array();
        for ($i = 0; $i < sizeof($especialidade_contratacao); $i++) {
            $esp_contrata[$i] = $especialidade_contratacao[$i]->especialidades_id;
        }
        $especialidade_contratacao = $esp_contrata;
        $unidades = Unidade::all();
        $unidadesMenu = Unidade::all();
        $unidade  = $unidadesMenu->find($id_und);
        return view('contratacao_servicos/contratacaoServicos_excluir', compact('contratacao_servicos', 'Unidades', 'sucesso', 'especialidades', 'especialidade_contratacao', 'id_und', 'unidades', 'unidadesMenu', 'unidade'));
    }

    //Excluir contratação
    public function excluirContratacao($id,$id_und)
    {
        $input['status'] = 0;
        $contratacao_servicos = ContratacaoServicos::where('id',$id);
        $contratacao_servicos->update($input);
        DB::statement('DELETE FROM contratacao_servicos_erratas WHERE contratacao_servicos_id = '.$id.';');
        DB::statement('UPDATE contratacao_servicos SET prazoProrroga = NULL WHERE id = '.$id.';');
        $unidades       = Unidade::all();
        $contratacao_servicos = ContratacaoServicos::where('status', 1);
        $especialidades = Especialidades::all();
        $unidades       = Unidade::all();
        $unidadesMenu   = Unidade::all();
        $validator      = "Contratação de serviço exluida com sucesso";
        return redirect()->route('paginaContratacaoServicos', $id_und)
                ->withErrors($validator)
                ->with('contratacao_servicos', 'Unidades','unidades', 'especialidades', 'sucesso', 'validator', 'unidade', 'unidadesMenu', 'id_und');
    }
    
    //Excluir arquivo contratação
    public function exclArqContratacao($id,$id_und, Request $request)
    {
        $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
        $pasta = $contratacao_servicos[0]->arquivo;
        Storage::delete($pasta);
        $input['arquivo']  = '';
        $input['nome_arq'] = '';
        $contratacao_servicos = ContratacaoServicos::find($id);
        $contratacao_servicos->update($input);
        $sucesso    = "ok";
        $contratacao_servicos = ContratacaoServicos::where('id', $id)->where('status',1)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $Unidades   = Unidade::all();
        $especialidades = Especialidades::all();
        $validator  = "Arquivo excluido com sucesso !";
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get('especialidades_id');
        return redirect()->route('pagAlterarContratacao', [$id, $unidade_id])
                          ->withErrors($validator);
    }

    //Pagina Alterar Contratacao
    public function pagAlterarContratacao($id, $id_und)
    {
        $sucesso    = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->where('status',1)->get();
        $unidade_id   = $contratacao_servicos[0]->unidade_id;
        $Unidades     = Unidade::all();
        $unidadesMenu = Unidade::all();
        $unidade      = $unidadesMenu->find($id_und);
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
        $esp_contrata = array();
        for ($i = 0; $i < sizeof($especialidade_contratacao); $i++) {
            $esp_contrata[$i] = $especialidade_contratacao[$i]->especialidades_id;
        }
        $especialidade_contratacao = $esp_contrata;
        return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'sucesso', 'especialidades', 'especialidade_contratacao', 'unidade_id', 'unidadesMenu', 'unidade', 'id_und'));
    }
    
    //Alterar dados contratacao
    public function alterarContratacao($id, $id_und, Request $request)
    {
        $input   = $request->all();
        $input['status'] = 1;
        $sucesso = "";
        $contratacao_servicos  = ContratacaoServicos::where('id', $id)->where('status',1)->get();
        $unidade_id = $contratacao_servicos[0]->unidade_id;
        $nome_arq   = $contratacao_servicos[0]->arquivo;
        $Unidades   = Unidade::all();
        $especialidades = Especialidades::all();
        $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
        $esp_contrata = array();
        for ($i = 0; $i < sizeof($especialidade_contratacao); $i++) {
            $esp_contrata[$i] = $especialidade_contratacao[$i]->especialidades_id;
        }
        $especialidade_contratacao = $esp_contrata;
        // Variaveis do navbar
        $unidadesMenu = Unidade::all();
        $unidade = $unidadesMenu->find($id_und);
        //Veriicando tipo de prazo.
        if ((isset($input['tipoPrazo']) == false)) {
            $input['tipoPrazo']  = 0;
            $input['prazoFinal'] = null;
        }
        $dtPrazoIni = $input['prazoInicial'];
        $dtPrazoFim = $input['prazoFinal'];
        $isTouch    = isset($input['nome_arq']);
        if ($isTouch == true) {
            $nome     = $_FILES['nome_arq']['name'];
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        }
        $validator = Validator::make($request->all(), [
            'texto'        => 'required|max:1000',
            'unidade_id'   => 'required|max:255',
            'prazoInicial' => 'required',
        ]);
        if ($validator->fails()) {
            $sucesso = "no";
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'sucesso', 'especialidades', 'especialidade_contratacao', 'unidade_id', 'unidadesMenu', 'unidade', 'id_und'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        } elseif ($dtPrazoIni >= $dtPrazoFim && $input['tipoPrazo'] == "1") {
            $sucesso = "no";
            $validator = 'A data inicial do prazo não pode ser maior ou igual que a data final !';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'especialidade_contratacao', 'unidade_id', 'unidadesMenu', 'unidade', 'id_und'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        } elseif ($nome_arq != "") {
            $contratacao_servicos   = ContratacaoServicos::find($id);
            $contratacao_servicos->update($input);
            $count   = sizeof($especialidades);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');
            $isTouch = isset($input['especialidade']);
            if ($isTouch) {
                $qtdEspSelec    = $input['especialidade'];
                $espContrAtuais = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
                //Exclusão de vinculo de especialidades não selecionadas
                for ($i = 0; $i < sizeof($espContrAtuais); $i++) {
                    if (in_array($espContrAtuais[$i]->especialidades_id, $qtdEspSelec) == false) {
                        EspecialidadeContratacao::find($espContrAtuais[$i]->id)->delete();
                    }
                }
                //Adição de vinculos de especialidades selecionadas que não estão vinculadas
                for ($i = 0; $i < sizeof($qtdEspSelec); $i++) {
                    $espContr = EspecialidadeContratacao::where('contratacao_servicos_id', $id)
                        ->where('especialidades_id', $qtdEspSelec[$i])
                        ->get();
                    $espContr = sizeof($espContr);
                    if ($espContr == 0) {
                        $input['contratacao_servicos_id'] =  $id;
                        $input['especialidades_id'] = $qtdEspSelec[$i];
                        $especialidade_contratacao  = EspecialidadeContratacao::all();
                        $especialidade_contratacao  = EspecialidadeContratacao::create($input);
                    }
                }
            }
            $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
            $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
            $esp_contrata = array();
            for ($i = 0; $i < sizeof($especialidade_contratacao); $i++) {
                $esp_contrata[$i] = $especialidade_contratacao[$i]->especialidades_id;
            }
            $especialidade_contratacao = $esp_contrata;
            $sucesso   = "ok";
            $validator = 'Contratação de serviço alterada com sucesso!';
            return redirect()->route('paginaContratacaoServicos', [$id_und])
                    ->withErrors($validator)
                    ->with('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'validator', 'unidade_id', 'especialidade_contratacao', 'unidadesMenu', 'unidade', 'id_und');
        } elseif ($request->file('nome_arq') === NULL) {
            $sucesso   = "no";
            $validator = 'Você esqueceu de anexar o arquivo!';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade_id', 'especialidade_contratacao', 'unidadesMenu', 'unidade', 'id_und'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } elseif ($extensao === 'pdf') {
            $nome = $_FILES['nome_arq']['name'];
            $request->file('nome_arq')->move('../public/storage/contratacao_servicos/', $nome);
            $input['arquivo']  = 'contratacao_servicos/' . $nome;
            $input['nome_arq'] = $nome;
            $input['prazoProrroga'] = null;
            $contratacao_servicos   = ContratacaoServicos::find($id);
            $contratacao_servicos->update($input);
            $count = sizeof($especialidades);
            $id_contratacao_servico = DB::table('contratacao_servicos')->max('id');
            $isTouch = isset($input['especialidade']);
            if ($isTouch) {
                $qtdEspSelec = $input['especialidade'];
                $espContrAtuais = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
                //Exclusão de vinculo de especialidades não selecionadas
                for ($i = 0; $i < sizeof($espContrAtuais); $i++) {
                    if (in_array($espContrAtuais[$i]->especialidades_id, $qtdEspSelec) == false) {
                        EspecialidadeContratacao::find($espContrAtuais[$i]->id)->delete();
                    }
                }
                //Adição de vinculos de especialidades selecionadas que não estão vinculadas
                for ($i = 0; $i < sizeof($qtdEspSelec); $i++) {
                    $espContr = EspecialidadeContratacao::where('contratacao_servicos_id', $id)
                        ->where('especialidades_id', $qtdEspSelec[$i])
                        ->get();
                    $espContr = sizeof($espContr);
                    if ($espContr == 0) {
                        $input['contratacao_servicos_id'] =  $id;
                        $input['especialidades_id'] = $qtdEspSelec[$i];
                        $especialidade_contratacao = EspecialidadeContratacao::all();
                        $especialidade_contratacao = EspecialidadeContratacao::create($input);
                    }
                }
            }
            $contratacao_servicos  = ContratacaoServicos::where('id', $id)->get();
            $especialidade_contratacao = EspecialidadeContratacao::where('contratacao_servicos_id', $id)->get();
            $esp_contrata = array();
            for ($i = 0; $i < sizeof($especialidade_contratacao); $i++) {
                $esp_contrata[$i] = $especialidade_contratacao[$i]->especialidades_id;
            }
            $especialidade_contratacao = $esp_contrata;
            $sucesso = "ok";
            $validator = 'Contratação de serviço alterada com sucesso!';
            return redirect()->route('paginaContratacaoServicos', [$id_und])
                    ->withErrors($validator)
                    ->with('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'validator', 'unidade_id', 'especialidade_contratacao', 'unidadesMenu', 'unidade', 'id_und');
        } else {
            $sucesso = "no";
            $validator = 'Só são permitidos os arquivos do tipo: PDF';
            return view('contratacao_servicos/contratacaoServicos_alterar', compact('contratacao_servicos', 'Unidades', 'especialidades', 'sucesso', 'unidade_id', 'especialidade_contratacao', 'unidadesMenu', 'unidade', 'id_und'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        }
    }
    
    //Pagina prorroga contrato
    public function pagProrrContratacao($id, $id_und)
    {
        $Unidades     = Unidade::all();
        $unidadesMenu = Unidade::all();
        $unidade      = $unidadesMenu->find($id_und);
        $sucesso      = "";
        $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
        $contratacao_erratas  = ContratacaoServicosErratas::where('contratacao_servicos_id',$id)->get();
        $qtd = sizeof($contratacao_erratas);
        return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'id_und', 'unidadesMenu', 'unidade','contratacao_erratas','qtd'));
    }

    //Prorrogação de contrato
    public function prorrContratacao($id, $id_und, Request $request)
    {
        $input = $request->all();
        $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
        $contratacao_erratas  = ContratacaoServicosErratas::where('contratacao_servicos_id',$id)->get();
        $qtd = sizeof($contratacao_erratas);
        $dtPrazoFim    = $contratacao_servicos[0]->prazoFinal;
        $PrazProAtual  = $contratacao_servicos[0]->prazoProrroga;
        $tipoPrazo     = $contratacao_servicos[0]->tipoPrazo;
        $unidades      = Unidade::all();
        $unidadesMenu  = Unidade::all();
        $unidade       = $unidadesMenu->find($id_und); 
        $dataHoraAtual = new DateTime();
        $dataHoraAtual = $dataHoraAtual->format('YmdHis');
        if ((isset($input['prazoProrroga'])) == FALSE) {
            $input['prazoProrroga'] = null;
        }
        $dtProrrgac = $input['prazoProrroga'];
        if ((isset($input['nome_arq_errata'])) == FALSE) {
            $input['nome_arq_errata'] = null;
        }
        $nomeArq = $input['nome_arq_errata'];
        if ($dtProrrgac == "" && $tipoPrazo == "1") {
            $sucesso = "no";
            $validator = "Você não digitou a nova data.";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'id_und', 'unidade', 'unidades', 'unidadesMenu', 'qtd', 'contratacao_erratas'))
                ->withErrors($validator);
        } elseif ($dtProrrgac <= $PrazProAtual && $tipoPrazo == 1) {
            $sucesso = "no";
            $validator = "Data prorroga menor ou igual a data de prorrogação Atual";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'id_und', 'unidade', 'unidades', 'unidadesMenu', 'qtd', 'contratacao_erratas'))
                ->withErrors($validator);
        } elseif ($dtProrrgac <= $dtPrazoFim && $tipoPrazo == 1) {
            $sucesso = "no";
            $validator = "Data prorroga menor ou igual a data final";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'id_und', 'unidade', 'unidades', 'unidadesMenu', 'qtd', 'contratacao_erratas'))
                ->withErrors($validator);
        } elseif ($nomeArq) {
            $nome = $_FILES['nome_arq_errata']['name'];
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            $extensao = strtolower($extensao);
            if ($extensao === 'pdf') {
              $nomeUnidade = $unidade->sigla;
              $input['dtup_errata'] = date('Y-m-d');
              $request->file('nome_arq_errata')->move('../public/storage/contratacao_servicos/'.$nomeUnidade.'/', $nome);
              $input['arquivo_errata'] = 'contratacao_servicos/'.$nomeUnidade.'/'. $nome;
              $input['nome_arq_errata'] = $nome;
              $sucesso = "ok";
              if($qtd == 0) {
                $input['posicao'] = 1;
              } else {
                $input['posicao'] = $qtd + 1;
              }
              $input['dtup_errata'] = $dtProrrgac;
              $input['contratacao_servicos_id'] = $id;
              $input['unidade_id']  = $id_und;
              $contratacao_servicos = ContratacaoServicos::find($id);
              $contratacao_servicos->update($input);
              $contratacao_servicos = ContratacaoServicosErratas::create($input);
              $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
              $contratacao_erratas  = ContratacaoServicosErratas::where('contratacao_servicos_id',$id)->get();
              $qtd = sizeof($contratacao_erratas); 
              $validator = 'Prorrogação efetuada com sucesso';
              return redirect()->route('pagProrrContratacao', [$id, $id_und])
                        ->withErrors($validator)
                        ->with('contratacao_servicos', 'sucesso', 'validator', 'qtd');
            } else {
                $validator = 'Só é aceito arquivo com a extenssão PDF !';
                return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'validator', 'id_und', 'unidade', 'unidades', 'unidadesMenu', 'qtd', 'contratacao_erratas'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
            }
        } else {
            $sucesso = "no";
            $validator = "Você precisar anexar o arquivo da errata";
            return view('contratacao_servicos/contratacaoServicos_prorroga', compact('contratacao_servicos', 'sucesso', 'id_und', 'unidade', 'unidades', 'unidadesMenu', 'qtd', 'contratacao_erratas'))
                     ->withErrors($validator);
        }
    }

    //Prorrogação de contrato
    public function excluirErrataContratacao($id, $idCE, $id_und)
    { 
        ContratacaoServicosErratas::find($idCE)->delete();
        $contratacao_servicos = ContratacaoServicos::where('id', $id)->get();
        $contratacao_erratas  = ContratacaoServicosErratas::where('contratacao_servicos_id',$id)->get();
        $qtd = sizeof($contratacao_erratas);
        if($qtd == 0) {
            DB::statement('UPDATE contratacao_servicos SET prazoProrroga = NULL WHERE id = '.$id.';');
        }
        $unidades      = Unidade::all();
        $unidadesMenu  = Unidade::all();
        $unidade       = $unidadesMenu->find($id_und); 
        $sucesso   = "ok";
        $validator = "Errata excluída com sucesso!";
        return redirect()->route('pagProrrContratacao', [$id, $id_und])
                  ->withErrors($validator)
                  ->with('contratacao_servicos', 'sucesso', 'validator', 'qtd', 'contratacao_erratas');
    }
    
    //Pagina Especialidade
    public function paginaEspecialidade($id_und)
    {
        $especialidades = Especialidades::all();
        $sucesso        = "";
        $unidadesMenu   = Unidade::all();
        $unidade        = $unidadesMenu->find($id_und);
        return view('contratacao_servicos/especialidades_listagem', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'));
    }

    //Pagina nova especialidade
    public function novaEspecialidade($id_und)
    {
        $especialidades = Especialidades::all();
        $sucesso        = "";
        $unidadesMenu   = Unidade::all();
        $unidade        = $unidadesMenu->find($id_und);
        return view('contratacao_servicos/especialidades_novo', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'));
    }
    
    //Salvar especialidade
    public function salvarEspecialidade($id_und, Request $request)
    {
        $input = $request->all();
        $nome  = $input['nome'];
        $especialidades = Especialidades::all();
        $especialiCad   = Especialidades::where('nome', $nome)->get('nome');
        $unidadesMenu   = Unidade::all();
        $unidade = $unidadesMenu->find($id_und);
        if ($especialiCad == '[]') {
            $novaEspecialidade = Especialidades::create($input);
            $sucesso   = "ok";
            $validator = 'Especialidade cadastrada com sucesso';
            return view('contratacao_servicos/especialidades_novo', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso   = "no";
            $validator = 'Especialidade Já está cadastrada !';
            return view('contratacao_servicos/especialidades_novo', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        }
    }
    
    //Pesquisar especialidade
    public function pesquisarEspecialidade($id_und, Request $request)
    {
        $sucesso      = "";
        $input        = $request->all();
        $unidadesMenu = Unidade::all();
        $unidade      = $unidadesMenu->find($id_und);
        $pesq         = $input['nomePesq'];
        if (!$pesq == "") {
            $especialidades = DB::table('especialidades')->where('nome', 'like', '%' . $pesq . '%')->get();
        } else {
            $especialidades = Especialidades::all();
        }
        return view('contratacao_servicos/especialidades_listagem', compact('especialidades', 'sucesso', 'unidadesMenu', 'unidade', 'id_und'));
    }
    
    //Pagina excluir especialidade
    public function pagExcluirEspecialidade($id, $id_und)
    {
        $sucesso        = "";
        $especialidades = Especialidades::where('id', $id)->get();
        $unidadesMenu   = Unidade::all();
        $unidade        = $unidadesMenu->find($id_und);
        return view('contratacao_servicos/especialidades_excluir', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'));
    }

    //Excluir especialidade
    public function excluirEspecialidade($id, $id_und)
    {
        $sucesso = "";
        EspecialidadeContratacao::where('especialidades_id', $id)->delete();
        Especialidades::find($id)->delete();
        $especialidades = Especialidades::all();
        $unidadesMenu   = Unidade::all();
        $unidade        = $unidadesMenu->find($id_und);
        return redirect()->route('paginaEspecialidade', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'));
    }
    
    //Pagina Alterar especialidade
    public function pagAlterarEspecialidade($id, $id_und)
    {
        $sucesso = "";
        $especialidades = Especialidades::where('id', $id)->get();
        $unidadesMenu   = Unidade::all();
        $unidade        = $unidadesMenu->find($id_und);
        return view('contratacao_servicos/especialidades_alterar', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'));
    }

    public function alterarEspecialidade($id, $id_und, Request $request)
    {
        $input = $request->all();
        $nome  = $input['nome'];
        $unidadesMenu = Unidade::all();
        $unidade   = $unidadesMenu->find($id_und);
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255'
        ]);
        $especialiCad = Especialidades::where('nome', $nome)->get('nome');
        if ($validator->fails()) {
            $sucesso   = "no";
            $validator = 'Nome muito longo!';
            return view('contratacao_servicos/especialidades_alterar', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        } elseif ($especialiCad == '[]') {
            $sucesso   = "ok";
            $validator = 'Nome alterado com sucesso!';
            $especialidades = Especialidades::find($id);
            $especialidades->update($input);
            $especialidades = Especialidades::where('id', $id)->get();
            return view('contratacao_servicos/especialidades_alterar', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        } else {
            $sucesso   = "no";
            $validator = 'Não foi indetificado alteração no nome!';
            $especialidades = Especialidades::where('id', $id)->get();
            return view('contratacao_servicos/especialidades_alterar', compact('especialidades', 'sucesso', 'id_und', 'unidadesMenu', 'unidade'))
                    ->withErrors($validator)
                    ->withInput(session()->flashInput($request->input()));
        }
    }
}