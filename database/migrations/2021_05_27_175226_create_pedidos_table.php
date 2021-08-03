<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained('users');
            $table->text('titulo');
            $table->text('descricao');
            $table->string('tipo');
            $table->integer('paginas')->nullable();
            $table->text('finalidade')->nullable();
            $table->text('formato')->nullable();
            $table->integer('paginas_diagramadas')->nullable();
            $table->integer('tiragem')->nullable();
            $table->integer('originais')->nullable();
            $table->integer('impressos')->nullable();
            $table->float('percentual_sobre_insumos')->nullable();
            $table->string('centro_de_despesa')->nullable();
            $table->integer('responsavel_centro_despesa')->nullable();
            $table->boolean('termo_responsavel_centro_despesa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
}
