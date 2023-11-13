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
        //Acessar a tabela "itens_vendas" e criar a coluna produto
        Schema::table('itens_vendas', function(Blueprint $table){
            $table->unsignedBigInteger('produto')->after('id');

            $table->foreign('produto')->references('id')->on('produtos');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Fazer a exclusão da coluna ao realizar o rollback
        Schema::table('itens_vendas', function(Blueprint $table){
            $table->dropColumn('produto');
        });
    }
};
