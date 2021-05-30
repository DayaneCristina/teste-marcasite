<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropostasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propostas', function (Blueprint $table) {
            $table->id();
            $table->string('endereco');
            $table->float('valor_total', 10,2);
            $table->float('sinal', 15,2)->nullable();
            $table->integer('quantidade_parcelas')->nullable();
            $table->boolean('status');
            $table->date('data_inicio_pagamento');
            $table->integer('dia_vencimento');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('servico_id');
            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->foreign('servico_id')->references('id')->on('servicos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propostas');
    }
}
