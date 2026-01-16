<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create("schedules", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("doctor_id")->constrained("doctors");
            $table
                ->tinyInteger("day")
                ->unsigned()
                ->nullable();
            $table->time("from_time")->nullable();
            $table->time("to_time")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop("schedules");
    }
}
