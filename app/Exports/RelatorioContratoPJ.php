<?php

namespace App\Exports;

use \DB;
use \Maatwebsite\Excel\Concerns\FromCollection;
use \Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use \Illuminate\Http\Request;
use App\Model\Prestador;

class RelatorioContratoPJ implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(int $id, int $id_)
    {
        $this->id = $id;
        $this->id_ = $id_;
    }

    public function collection()
    {
        $tipoServ = '';
        if ($this->id_ == 1){
            $tipoServ = 'OBRAS';
        } elseif ($this->id_ == 2){
            $tipoServ = 'SERVIÇOS';
        } elseif ($this->id_ == 3){
            $tipoServ = 'AQUISIÇÃO DE BENS';
        } else {
            $tipoServ = 'ID INVÁLIDO';
        }

        $contratos = DB::table('contratos')
			->join('prestadors', 'contratos.prestador_id', '=', 'prestadors.id')
			->leftjoin('aditivos', 'aditivos.contrato_id', '=', 'contratos.id')
			->join('unidades', 'unidades.id', '=', 'contratos.unidade_id')
			->select(
                'unidades.cnpj as cnpj_unidade',
                'unidades.name as nome_unidade',
                'prestadors.id as prestador_id',
                'prestadors.cnpj_cpf as cnpj_prestador',
                'prestadors.prestador as prestador',
                'prestadors.tipo_contrato as tipo_contrato_prestador',
				'contratos.objeto as objeto_contrato',
				'contratos.inicio as data_assinatura',
				'contratos.fim as termino_da_vigencia',
                'contratos.valor as valor_total',
                'contratos.file_path as link_contrato',
                'aditivos.vinculado as numero_ta',
                'aditivos.opcao as opcao'
			)
			->where('contratos.unidade_id', $this->id)
			->where('prestadors.tipo_contrato', $tipoServ)
			->orderBy('prestadors.prestador', 'ASC')
			->get(); 
            $qtd = sizeof($contratos); 
            $prestadores = Prestador::where('tipo_contrato', $tipoServ)->get();
            $qtdP = sizeof($prestadores);
            $b = 0; //Contador Contratos  
            $c = 0; //Contador Aditivos
            for ($p = 0; $p < $qtdP; $p++) {    
              $b += 1; $c += 1;   
                for ($a = 0; $a < $qtd; $a++) {
                    if ($contratos[$a]->prestador_id == $prestadores[$p]->id) {
                        if($contratos[$a]->opcao == 0) {
                            $contratos[$a]->opcao = $b.'º Contrato';  
                        } else if($contratos[$a]->opcao == 1) {
                            $contratos[$a]->opcao = $c.'º Aditivo';  
                        } else if($contratos[$a]->opcao == 2) {
                            $contratos[$a]->opcao = 'Distrato'; 
                        } else if($contratos[$a]->opcao == 3) {
                            $contratos[$a]->opcao = 'Rerratificação'; 
                        }
                        $b += 1; $c += 1;
                    }
                    
                }
                $b = 0; $c = 0;
                
            }
            return $contratos;
    }

    public function headings(): array
    {
        return [
            'CNPJ da Unidade de Saúde',
            'Nome da Unidade de Saúde',
            'Id Fornecedor',
            'CNPJ do Fornecedor',
            'Nome do Fornecedor',
            'Tipo de contrato do Fornecedor',
            'Objeto do Contrato',
            'Data da Assinatura',
            'Termino da Vigência',
            'Valor Total',
            'Link para o contrato',
            'Número do TA',
            'Tipo do TA'
        ];
    }
}
