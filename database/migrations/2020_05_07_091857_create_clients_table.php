<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
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

            $table->unsignedBigInteger('child_id')->unique();
            $table->unsignedBigInteger('client_status')->default(1);
            $table->unsignedInteger('count_hour')->default(0);
            $table->unsignedInteger('discount_hour')->default(0);
            $table->date('last_record')->nullable();

            $table->foreign('child_id')->references('id')->on('children')->onDelete('cascade');

            $table->foreign('client_status')->references('id')->on('statuses');
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
    }
}
