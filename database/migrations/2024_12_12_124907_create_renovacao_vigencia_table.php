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
        Schema::create('renovacao_vigencia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contrato_id');
            $table->string('nome_vigencia'); 
            $table->string('unidade_id'); 
            $table->string('numero_aditivo'); 
            $table->string('nome_empresa'); 
            $table->string('cnpj_empresa'); 
            $table->string('endereco_empresa'); 
            $table->date('data_inicio_contrato'); 
            $table->date('data_fim_contrato'); 
            $table->date('prazo_vigencia'); 
            $table->date('data_assinatura'); 
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
        Schema::dropIfExists('renovacao_vigencia');
    }
};
