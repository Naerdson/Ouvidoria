<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoContatoOuvidoriasOcorrenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ouvidorias_ocorrencias', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_contato_id')->after('contato');

            $table->foreign('tipo_contato_id')->references('id')->on('tipos_contatos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ouvidorias_ocorrencias', function (Blueprint $table) {
            $table->dropForeign(['tipo_contato_id']);
        });
    }
}
