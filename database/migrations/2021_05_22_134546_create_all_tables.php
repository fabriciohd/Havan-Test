<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });

        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->string('id_client')->references('id')->on('clients');
            $table->string('origin_currency');
            $table->string('destiny_currency');
            $table->float('original_value', 10, 2);
            $table->float('converted_value', 10, 2);
            $table->text('rate');
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
        Schema::dropIfExists('clients');
        Schema::dropIfExists('operations');
    }
}
