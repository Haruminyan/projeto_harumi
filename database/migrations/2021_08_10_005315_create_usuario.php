<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) 
        {
            $table->id();
            $table->string('nome');
            $table->string('cpf_cnpj')->unique();
            $table->string('email')->unique();
            $table->integer('tipo');
            $table->string('senha');
            $table->double('saldo', 8, 2);
            $table->timestamps();            
          }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
