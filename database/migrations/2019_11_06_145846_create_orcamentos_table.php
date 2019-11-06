<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrcamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
			$table->string('titulo');
			$table->string('procedencia')->nullable();
			$table->string('area')->nullable();
			$table->string('responsavel')->nullable();
			$table->string('tiragem')->nullable();
			$table->string('originais')->nullable();
			$table->string('formato')->nullable();
			$table->string('fonte')->nullable();
			$table->text('observacao')->nullable();
			$table->integer('ano')->nullable();
			$table->integer('cs')->nullable();
			$table->date('entrada')->nullable();

		});
			




    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orcamentos');
    }
}
