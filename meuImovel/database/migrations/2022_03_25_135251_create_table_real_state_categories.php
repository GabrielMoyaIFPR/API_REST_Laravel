<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRealStateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Real_State_Categories', function (Blueprint $table) {
           $table->unsignedBigInteger('real_state_id');
           $table->unsignedBigInteger('category_id');

           $table->foreign('real_state_id')->references('id')->on('Real_State');
           $table->foreign('category_id')->references('id')->on('Categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Real_State_Categories');
    }
}
