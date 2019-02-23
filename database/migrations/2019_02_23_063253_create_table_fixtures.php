<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFixtures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixtures', function (Blueprint $table){
            $table->increments('id');
            $table->Integer('home_id')->default(0);
            $table->string('type')->nullable();
            $table->string('group');
            $table->Integer('opponent_id');
            $table->Integer('winner_id')->default(0);
            $table->Integer('round')->default(0);
            $table->Integer('loss_margin_score')->default(0);;
            $table->Integer('loss_margin_wickets')->default(0);;
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
        Schema::dropIfExists('fixtures');
    }
}
