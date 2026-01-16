<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixRelationConstarions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("reservations", function (Blueprint $table) {
            $table->dropForeign(["schedule_id"]);
            $table
                ->unsignedBigInteger("schedule_id")
                ->nullable()
                ->change();
            $table
                ->foreign("schedule_id")
                ->references("id")
                ->on("schedules")
                ->nullOnDelete();
        });

        Schema::table("ratings", function (Blueprint $table) {
            $table->dropForeign(["reservation_id"]);
            $table
                ->unsignedBigInteger("reservation_id")
                ->nullable()
                ->change();

            $table
                ->foreign("reservation_id")
                ->references("id")
                ->on("reservations")
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
