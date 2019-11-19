<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('titulo');
            $table->string('procedencia');
            $table->string('area');
            $table->string('responsavel');
            $table->string('tiragem');
            $table->string('originais');
            $table->string('formato');
            $table->string('fonte pagadora');
            $table->text('observação');
            $table->integer('tipo');
            $table->integer('ano');
            $table->integer('numero_cs');
            $table->date('entrada');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamento');
    }
}
