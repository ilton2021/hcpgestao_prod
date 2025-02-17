<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrato_servico_medico', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contrato_id');
            $table->string('nome_contrato'); 
            $table->string('unidade_id'); 
            $table->string('nome_empresa'); 
            $table->string('cnpj_empresa'); 
            $table->string('endereco_empresa'); 
            $table->string('especialidade_medica'); 
            $table->string('numero_consultas_mensais'); 
            $table->string('nome_exame'); 
            $table->string('valor_unitario_consulta'); 
            $table->date('data_inicio_contrato'); 
            $table->date('data_fim_contrato'); 
            $table->date('prazo_vigencia'); 
            $table->string('data_assinatura'); 
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contrato_servico_medico');
    }
};
