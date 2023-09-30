<?php

use App\Models\Cliente;
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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->string('modoRecebimento');
            $table->integer('parcelas');
            $table->double('saldoReceber');
            $table->date('vencimento');
            $table->string('logradouro');
            $table->integer('numero');
            $table->string('CEP');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('statusEntrega');
            $table->unsignedBigInteger('cliente');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('cliente')->references('id')->on('clientes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
};
