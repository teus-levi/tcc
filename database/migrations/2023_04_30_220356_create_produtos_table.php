<?php
use App\Models\Marca;
use App\Models\Categoria;
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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->text('imagem');
            $table->text('descricao');
            $table->double('precoVendaAtual');
            $table->unsignedBigInteger('marca');
            $table->unsignedBigInteger('categoria');
            $table->unsignedBigInteger('administrador');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('marca')->references('id')->on('marcas');
            $table->foreign('categoria')->references('id')->on('categorias');
            $table->foreign('administrador')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
