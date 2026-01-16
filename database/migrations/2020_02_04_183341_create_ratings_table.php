<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("ratings", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table
                ->tinyInteger("rate")
                ->unsigned()
                ->index()
                ->default("0");
            $table->foreignId("reservation_id")->constrained("reservations");
            $table
                ->foreignId("doctor_id")
                ->constrained("doctors")
                ->cascadeOnDelete();
            $table
                ->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::drop("ratings");
    }
}
