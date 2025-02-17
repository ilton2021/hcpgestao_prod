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
        Schema::create('distratos_layout', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('contrato_id');
            $table->string('nome_distrato'); 
            $table->string('unidade_id');
            $table->string('nome_empresa'); 
            $table->string('cnpj_empresa'); 
            $table->string('endereco_empresa'); 
            $table->string('resumo'); 
            $table->date('data_inicio_contrato'); 
            $table->date('data_inicio_distrato'); 
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
        Schema::dropIfExists('distratos_layout');
    }
};
