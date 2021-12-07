<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWebService extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_service', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 40);
            $table->string('api_server', 255);
            $table->string('api_http_user', 40);
            $table->string('api_http_pass', 40);
            $table->string('chave_acesso', 40);
            $table->string('chave_name', 40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('web_service');
    }
}
