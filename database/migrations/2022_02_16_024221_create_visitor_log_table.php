<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitor_log', function (Blueprint $table) {
            $table->id();
            $table->string('log_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->dateTime('in_time');
            $table->dateTime('out_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitor_log');
    }
}
