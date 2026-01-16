<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("reservations", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignId("doctor_id")->constrained("doctors");
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("schedule_id")->constrained("schedules");
            $table
                ->foreignId("promocode_id")
                ->nullable()
                ->constrained("promocodes")
                ->nullOnDelete();
            $table->date("date");
            $table->time("from_time");
            $table->time("to_time");
            $table->timestamp("canceled_at")->nullable();
            $table
                ->enum("status", [
                    "active",
                    "cancled",
                    "finished",
                    "on_call",
                    "wait_confirmation",
                ])
                ->nullable();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::drop("reservations");
    }
}
