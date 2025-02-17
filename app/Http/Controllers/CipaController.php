<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\Cipa;
use App\Models\LoggerUsers;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CipaController extends Controller
{
    public function transparenciaCipaLista()
    {
        $cipas = Cipa::all();
        return view('transparencia.cipa.cipa_lista', compact('cipas'));
    }

    public function transparenciaCipa()
    {
        return view('transparencia.cipa.cipa_index');
    }

    public function transparenciaCipaCadastro()
    {
        return view('transparencia.cipa.cipa_cadastro_novo');
    }

    public function storeCipaCadastro(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'condicoes_inseguras' => 'required|max:255',
            'local_condicoes'     => 'required|max:255',
            'observacao'          => 'required|max:1000'
        ]);
        if ($validator->fails()) {
            return view('transparencia.cipa.cipa_cadastro_novo', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'))
                ->withErrors($validator)
                ->withInput(session()->flashInput($request->input()));
        } else {
            if ($input['condicoes_inseguras'] == 'outros') {
                if ($input['condicoes_inseguras_text'] == "") {
                    return view('transparencia.cipa.cipa_cadastro_novo', compact('unidade', 'unidades', 'unidadesMenu', 'competenciasMatriz', 'lastUpdated'))
                        ->withErrors($validator)
                        ->withInput(session()->flashInput($request->input()));
                } else {
                    $input['condicoes_inseguras'] = $input['condicoes_inseguras_text'];
                }
            }
            $cipa = Cipa::create($input);    
            $validator = 'Formulário respondido com sucesso!';
            return redirect()->route('transparenciaCipa')->withErrors($validator);
        }


        $unidadesMenu = Unidade::where('status_unidades', 1)->get();
        $unidade      = Unidade::where('status_unidades', 1)->find($id);
        return view('transparencia.cipa_cadastro', compact('unidade', 'unidadesMenu'));
    }
}
