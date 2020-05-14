<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->time('hour');
            $table->unsignedBigInteger('day_id');
            $table->unsignedBigInteger('group_id');
            $table->boolean('status')->default(false);

            $table->unsignedSmallInteger('count')->default(0);

            $table->foreign('group_id')->references('id')->on('groups');

            $table->foreign('day_id')->references('id')->on('days');
            $table->unique(['hour', 'day_id','group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hours');
    }
}
