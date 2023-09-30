<?php

use App\Models\Venda;
use App\Models\ProdutoFarmacia;
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
        Schema::create('itens_vendas', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade');
            $table->double('valorUnitario');
            $table->unsignedBigInteger('venda');
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('itens_vendas');
    }
};
