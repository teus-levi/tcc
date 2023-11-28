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
        Schema::create('notificacao', function (Blueprint $table) {
            $table->id();
            $table->integer('lido')->default(0);
            $table->text('descricao');
            $table->unsignedBigInteger('estoque')->nullable();
            $table->unsignedBigInteger('venda')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('estoque')->references('id')->on('estoques');
            $table->foreign('venda')->references('id')->on('vendas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificacao');
    }
};
