<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Model\Contrato;
use App\Model\Aditivo;
use App\Model\Unidade;
use App\Model\Prestador;
use App\Model\GestorContrato;
use App\Model\Gestor;
use App\Model\Documentos;
use DB;

class ContratosCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contratos:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $hoje = date('Y-m-d', (strtotime('now')));

        

        $contratos = DB::table('contratos')
            ->join('gestor_contrato', 'gestor_contrato.contrato_id', '=', 'contratos.id')
            ->join('unidades', 'unidades.id', '=', 'contratos.unidade_id')
            ->join('gestor', 'gestor.id', '=', 'gestor_contrato.gestor_id')
            ->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
            ->select(
                'contratos.id as id',
                'contratos.fim as fim',
                'contratos.aviso_venc90 as aviso_venc90',
                'contratos.aviso_venc60 as aviso_venc60',
                'contratos.file_path',
                'unidades.id as idUnd',
                'unidades.name as unidade',
                'unidades.sigla as undSigla',
                'gestor.nome',
                'gestor.email as emailGestor',
                'prestadors.prestador as prestador'
            )
            ->get();
        $qtd = sizeof($contratos);
        for ($i = 0; $i < $qtd; $i++) {
            $data90 = date('Y-m-d', strtotime('-90 days', strtotime($contratos[$i]->fim)));
            $aviso_venc90 = $contratos[$i]->aviso_venc90;
            $data60 = date('Y-m-d', strtotime('-60 days', strtotime($contratos[$i]->fim)));
            $aviso_venc60 = $contratos[$i]->aviso_venc60;
            $link = $contratos[$i]->file_path;
            $http = "http";
            $prestador = $contratos[$i]->prestador;
            $undNome   = $contratos[$i]->unidade;
            $undSigla  = $contratos[$i]->undSigla;
            $idUnd     = $contratos[$i]->idUnd;
            $EmailGestor = $contratos[$i]->emailGestor;
            $inativa   = $contratos[$i]->inativa;
            if($link == NULL){
             $link = "";   
            }
            if (str_contains($link,$http) == false) {
                $link = "https://hcpgestao-portal.hcpgestao.org.br/storage/" . $link;
            }
            if ((strtotime($hoje) == strtotime($data90)) && ($aviso_venc90 == 0 || $aviso_venc90 == "") && ($inativa == 0)) {
                $diasVenc = "90 dias";
                echo "entrou 90 Contrato";
                echo " | ";
                DB::statement('UPDATE contratos SET aviso_venc90 = 1 WHERE id = ' . $contratos[$i]->id . ';');
                Mail::send('email.contatoEmail', [
                    'link' => '' . $link . '',
                    'prestador' => '' . $prestador . '',
                    'undNome' => '' . $undNome . '',
                    'undSigla' => '' . $undSigla . '',
                    'diasVenc' => '' . $diasVenc . '',
                    'idUnd' => '' . $idUnd . '',
                ], function ($m) use ($EmailGestor) {
                    $m->from('portal@hcpgestao.org.br', 'Portal da Transparencia');
                    $m->subject('Contratos prestes a vencer!');
                    $m->to($EmailGestor);
                });
                sleep(60);
            } elseif ((strtotime($hoje) == strtotime($data60)) && ($aviso_venc60 == 0 || $aviso_venc60 == "") && ($inativa == 0)) {
                $diasVenc = "60 dias";
                DB::statement('UPDATE contratos SET aviso_venc60 = 1 WHERE id = ' . $contratos[$i]->id . ';');
                echo "entrou 60 CONTRATO";
                echo " | ";
                Mail::send('email.contatoEmail', [
                    'link' => '' . $link . '',
                    'prestador' => '' . $prestador . '',
                    'undNome' => '' . $undNome . '',
                    'undSigla' => '' . $undSigla . '',
                    'diasVenc' => '' . $diasVenc . '',
                    'idUnd' => '' . $idUnd . '',
                ], function ($m) use ($EmailGestor) {
                    $m->from('portal@hcpgestao.org.br', 'Portal da Transparencia');
                    $m->subject('Contratos prestes a vencer!');
                    $m->to($EmailGestor);
                });
                sleep(60);
            } else {
                DB::statement('UPDATE contratos SET aviso_venc90 = 0 WHERE id = ' . $contratos[$i]->id . ';');
                DB::statement('UPDATE contratos SET aviso_venc60 = 0 WHERE id = ' . $contratos[$i]->id . ';');
            }
        }
        $aditContra = DB::table('aditivos')
            ->join('contratos', 'contratos.id', '=', 'aditivos.contrato_id')
            ->join('gestor_contrato', 'gestor_contrato.contrato_id', '=', 'contratos.id')
            ->join('unidades', 'unidades.id', '=', 'aditivos.unidade_id')
            ->join('gestor', 'gestor.id', '=', 'gestor_contrato.gestor_id')
            ->join('prestadors', 'prestadors.id', '=', 'contratos.prestador_id')
            ->select(
                'aditivos.id as id',
                'aditivos.fim as fim',
                'aditivos.aviso_venc90 as aviso_venc90',
                'aditivos.aviso_venc60 as aviso_venc60',
                'aditivos.opcao',
                'aditivos.file_path',
                'unidades.id as idUnd',
                'unidades.name as unidade',
                'unidades.sigla as undSigla',
                'gestor.nome',
                'gestor.email as emailGestor',
                'prestadors.prestador as prestador'
            )->where('aditivos.opcao', '=', 0)
            ->orWhere('aditivos.opcao', '=', 1)
            ->get();

        $qtd = sizeof($aditContra);
        for ($i = 0; $i < $qtd; $i++) {
            $data90 = date('Y-m-d', strtotime('-90 days', strtotime($aditContra[$i]->fim)));
            $aviso_venc90 = $aditContra[$i]->aviso_venc90;
            $data60 = date('Y-m-d', strtotime('-60 days', strtotime($aditContra[$i]->fim)));
            $aviso_venc60 = $aditContra[$i]->aviso_venc60;
            $link = $aditContra[$i]->file_path;
            $http = "http";
            $prestador = $aditContra[$i]->prestador;
            $undNome = $aditContra[$i]->unidade;
            $undSigla = $aditContra[$i]->undSigla;
            $idUnd = $aditContra[$i]->idUnd;
            $EmailGestor = $aditContra[$i]->emailGestor;
            $inativa   = $aditContra[$i]->inativa;
            if($link == NULL){
             $link = "";   
            }
            if (str_contains($link,$http) == false) {
                $link = "https://hcpgestao-portal.hcpgestao.org.br/storage/" . $link;
            }
            if ((strtotime($hoje) == strtotime($data90)) && ($aviso_venc90 == 0 || $aviso_venc90 == "") && ($aditContra == 0)) {
                $diasVenc = "90 dias";
                echo "entrou 90 Aditivo";
                echo " | ";
                DB::statement('UPDATE aditivos SET aviso_venc90 = 1 WHERE id = ' . $aditContra[$i]->id . ';');
                Mail::send('email.contatoEmail', [
                    'link' => '' . $link . '',
                    'prestador' => '' . $prestador . '',
                    'undNome' => '' . $undNome . '',
                    'undSigla' => '' . $undSigla . '',
                    'diasVenc' => '' . $diasVenc . '',
                    'idUnd' => '' . $idUnd . '',
                ], function ($m) use ($EmailGestor) {
                    $m->from('portal@hcpgestao.org.br', 'Portal da Transparencia');
                    $m->subject('Contratos prestes a vencer!');
                    $m->to($EmailGestor);
                });
                sleep(60);
            } elseif ((strtotime($hoje) == strtotime($data60)) && ($aviso_venc60 == 0 || $aviso_venc60 == "") && ($aditContra == 0)) {
                $diasVenc = "60 dias";
                DB::statement('UPDATE aditivos SET aviso_venc60 = 1 WHERE id = ' . $aditContra[$i]->id . ';');
                echo "entrou 60 Aditivo";
                echo " | ";
                Mail::send('email.contatoEmail', [
                    'link' => '' . $link . '',
                    'prestador' => '' . $prestador . '',
                    'undNome' => '' . $undNome . '',
                    'undSigla' => '' . $undSigla . '',
                    'diasVenc' => '' . $diasVenc . '',
                    'idUnd' => '' . $idUnd . '',
                ], function ($m) use ($EmailGestor) {
                    $m->from('portal@hcpgestao.org.br', 'Portal da Transparencia');
                    $m->subject('Contratos prestes a vencer!');
                    $m->to($EmailGestor);
                });
                sleep(60);
            } else {
                DB::statement('UPDATE aditivos SET aviso_venc90 = 0 WHERE id = ' . $aditContra[$i]->id . ';');
                DB::statement('UPDATE aditivos SET aviso_venc60 = 0 WHERE id = ' . $aditContra[$i]->id . ';');
            }
        }

        $documentos = DB::table('documentos')
            ->join('unidades', 'unidades.id', '=', 'contratos.unidade_id')
            ->select(
                'documentos.id as id',
                'documentos.fim as data_fim',
                'documentos.dias_para_vencer as dias_para_vencer',
                'documentos.status_vencimento as status_vencimento',
                'documentos.status',
                'unidades.id as idUnd',
                'unidades.name as unidade',
                'unidades.sigla as undSigla'
            )
            ->get();
        $qtd = sizeof($contratos);
        for ($d = 0; $d < $qtd; $d++) {

            $dpv = $documentos[0]->dias_para_vencer;
            $stsv = $documentos[0]->status_vencimento;

            if ($dpv == "90" && $stsv == "90 DIAS PARA VENCER") {

            }  else if ($dpv == "30" && $stsv == "30 DIAS PARA VENCER") {

            } 

            Mail::send('email.contatoEmailLicencas', [
                'link' => '' . $link . '',
                'prestador' => '' . $prestador . '',
                'undNome' => '' . $undNome . '',
                'undSigla' => '' . $undSigla . '',
                'diasVenc' => '' . $diasVenc . '',
                'idUnd' => '' . $idUnd . '',
            ], function ($m) use ($EmailGestor) {
                $m->from('portal@hcpgestao.org.br', 'Portal da Transparencia');
                $m->subject('Contratos prestes a vencer!');
                $m->to($EmailGestor);
            });
            sleep(60);
        }
    }
}
