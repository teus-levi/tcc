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
        //
        Schema::table('vendas', function(Blueprint $table){
            $table->text('descricao')->nullable()->after('estado');
            $table->string('nomeRecebedor')->after('vencimento');
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
        Schema::table('vendas', function(Blueprint $table){
            $table->dropColumn('descricao');
            $table->dropColumn('nomeRecebedor');
        });
    }
};
