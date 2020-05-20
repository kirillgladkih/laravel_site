<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('children', function (Blueprint $table) {
            $table->id();

            $table->char('fio',100);
            

            $table->unsignedBigInteger('procreator_id');
            $table->unsignedTinyInteger('age');

            $table->unsignedBigInteger('group_id');

            $table->foreign('procreator_id')->references('id')->on('procreators');
            
            $table->foreign('group_id')->references('id')->on('groups');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('children');
    }
}
