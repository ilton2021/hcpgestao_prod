<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documentacao;
use App\Models\Unidade;
use App\Models\PermissaoUsers;
use App\Models\CertificadoIntegridade;
use Validator;
use Auth;

class DocumentacaoController extends Controller
{
    public function cadastroDocumentacoes($id_und){
        if(Auth::check()){
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $permissao_users = PermissaoUsers::where('unidade_id', $id_und)->get();
            $integridade  = CertificadoIntegridade::where('status_integridade', 1)->get();
            $lastUpdated  = $integridade->max('updated_at');
            $documentacoes = Documentacao::all();
            return view('documentacao/cadastros', compact('documentacoes', 'unidade', 'unidadesMenu', 'permissao_users', 'lastUpdated'));
        } else {
            $validator = 'Você não tem permissão para acessar esta área';
            return redirect()->back()
                ->withErrors($validator);
        }
        
    }

    public function novoDocumentacao($id_und){
        if(Auth::user()->id == 1){
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            return view('documentacao/novo', compact('unidade', 'unidadesMenu'));
        } else {
            $validator = 'Você não tem permissão para acessar esta área';
            return redirect()->back()
                ->withErrors($validator);
        }
    }

    public function storeDocumentacao(Request $request, $id_und){
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255',
            'arquivo' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()
                    ->withErrors($validator);
        }

        if(Documentacao::where('nome', [$input['nome']])->exists()){
            $validator = 'Já existe uma documentação cadastrada com este mesmo nome, por favor, insira outro nome para a documentação.';
            return redirect()->back()
                ->withErrors($validator);
        }

        if(Documentacao::where('arquivo', [$input['arquivo']])->exists()){
            $validator = 'Já existe um arquivo de documentação cadastrado com este mesmo nome, por favor, renomeie o arquivo ou insira outro.';
            return redirect()->back()
                ->withErrors($validator);
        }

        $nome = $_FILES['arquivo']['name'];
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        if ($extensao == 'pdf' || $extensao == 'PDF'){
            $request->file('arquivo')->move('../public/storage/documentacoes/', $nome);
            $input['caminho'] = 'documentacoes/'.$nome;
            $input['arquivo'] = $nome;
            $documentacao = Documentacao::create($input);
            $validator = 'Documentação Cadastrada com Sucesso.';
            return redirect()->route('cadastroDocumentacoes', [$id_und])
                    ->withErrors($validator);
        } else {
            $validator = 'Só é Suportado o Cadastro de Arquivos .pdf';
            return redirect()->back()
                    ->withErrors($validator);
        }
    }

    public function alterarDocumentacao($id_und, $id){
        if(Auth::user()->id == 1){
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $documentacao = Documentacao::where('id', $id)->get();
            return view('documentacao/alterar', compact('documentacao', 'unidade', 'unidadesMenu'));
        } else {
            $validator = 'Você não tem permissão para acessar esta área';
            return redirect()->back()
                ->withErrors($validator);
        }
    }

    public function updateDocumentacao(Request $request, $id_und, $id){
        $input = $request->all();
        $arquivo = Documentacao::where('id', $id)->get();
        $validator = Validator::make($request->all(), [
            'nome' => 'required|max:255',            
        ]);
        if($validator->fails()){
            return redirect()->back()
                    ->withErrors($validator);
        }

        if(Documentacao::where('nome', [$input['nome']])->exists()){
            $validator = 'Já existe uma documentação cadastrada com este mesmo nome, por favor, insira outro nome para a documentação.';
            return redirect()->back()
                ->withErrors($validator);
        }

        if(Documentacao::where('arquivo', [$input['arquivo']])->exists()){
            $validator = 'Já existe um arquivo de documentação cadastrado com este mesmo nome, por favor, renomeie o arquivo ou insira outro.';
            return redirect()->back()
                ->withErrors($validator);
        }

        if($_FILES['arquivo']['size'] != 0){
            unlink('../public/storage/documentacoes/'.$arquivo[0]->arquivo);
            $nome = $_FILES['arquivo']['name'];
            $extensao = pathinfo($nome, PATHINFO_EXTENSION);
            if ($extensao == 'pdf' || $extensao == 'PDF'){
                $request->file('arquivo')->move('../public/storage/documentacoes/', $nome);
                $input['caminho'] = 'documentacoes/'.$nome;
                $input['arquivo'] = $nome;
                $documentacao = Documentacao::find($id);
                $documentacao->update($input);
                $validator = 'Documentação Alterada com Sucesso.';
                return redirect()->route('cadastroDocumentacoes', [$id_und])
                        ->withErrors($validator);
            } else {
                $validator = 'Só é Suportado o Cadastro de Arquivos .pdf';
                return redirect()->back()
                        ->withErrors($validator);
            }
        } else {
            $documentacao = Documentacao::find($id);
            $documentacao->update(array('nome' => $input['nome']));
            $validator = 'Cadastro da Documentação Alterado com Sucesso.';
            return redirect()->route('cadastroDocumentacoes', [$id_und])
                    ->withErrors($validator);
        }
    }

    public function deleteDocumentacao($id_und, $id){
        if(Auth::user()->id == 1){
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $documentacao = Documentacao::where('id', $id)->get();
            return view('documentacao/excluir', compact('documentacao', 'unidade', 'unidadesMenu'));
        } else {
            $unidade = Unidade::find($id_und);
            $unidadesMenu = Unidade::all();
            $documentacao = Documentacao::where('id', $id)->get();
            return view('documentacao/alterar', compact('documentacao', 'unidade', 'unidadesMenu'));
        }
    }

    public function destroyDocumentacao($id_und, $id){
        $arquivo = Documentacao::where('id', $id)->get();
        unlink('../public/storage/documentacoes/'.$arquivo[0]->arquivo);
        $documentacao = Documentacao::find($id)->delete();
        $validator = 'Cadastro da Documentação Deletado com Sucesso.';
        return redirect()->route('cadastroDocumentacoes', [$id_und])
                ->withErrors($validator);
    }
}
