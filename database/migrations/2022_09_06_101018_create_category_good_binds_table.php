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
        Schema::create('category_good_binds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('category_id', false, true);
            $table->bigInteger('good_id', false, true);
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('good_id')->references('id')->on('goods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_good_binds');
    }
};
