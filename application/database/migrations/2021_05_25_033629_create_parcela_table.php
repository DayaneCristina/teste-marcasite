<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParcelaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parcela', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->float('valor', 15,2);
            $table->float('taxa', 10,3)->nullable();
            $table->date('data_vencimento');
            $table->text('observacao');
            $table->unsignedBigInteger('proposta_id');
            $table->timestamps();

            $table->foreign('proposta_id')->references('id')->on('propostas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcela');
    }
}
