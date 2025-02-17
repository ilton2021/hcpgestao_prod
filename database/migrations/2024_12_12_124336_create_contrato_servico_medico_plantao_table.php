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
        Schema::create('contrato_servico_medico_plantao', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contrato_id');
            $table->string('nome_contrato'); 
            $table->string('unidade_id'); 
            $table->string('nome_empresa'); 
            $table->string('cnpj_empresa'); 
            $table->string('endereco_empresa'); 
            $table->string('especialidade_medica');
            $table->date('data_inicio_contrato'); 
            $table->date('prazo_vigencia'); 
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
        Schema::dropIfExists('contrato_servico_medico_plantao');
    }
};
