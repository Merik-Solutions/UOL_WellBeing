<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("prescriptions", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("reservation_id")->constrained("reservations");
            $table->foreignId("doctor_id")->constrained("doctors");
            $table->foreignId("user_id")->constrained("users");
            $table->char("code")->nullable();
            $table->string("diagnosis")->nullable();
            $table->string("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::drop("prescriptions");
    }
}
