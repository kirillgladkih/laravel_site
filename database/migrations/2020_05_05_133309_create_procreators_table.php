<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcreatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procreators', function (Blueprint $table) {
            $table->id();

            $table->char('fio',100);
           
            $table->string('viber')->nullable()->unique();
            $table->string('vk')->nullable()->unique();

            $table->char('phone',12)->unique();
            
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('procreators');
    }
}
