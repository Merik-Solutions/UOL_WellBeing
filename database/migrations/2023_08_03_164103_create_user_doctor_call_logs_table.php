<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDoctorCallLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_doctor_call_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('initiator')->nullable();
            $table->foreignId('initiator_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('user_doctor_call_logs');
    }
}
