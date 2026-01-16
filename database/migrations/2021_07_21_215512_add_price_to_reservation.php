<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceToReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("reservations", function (Blueprint $table) {
            $table
                ->decimal("price", 10, 5)
                ->default(0)
                ->after("promocode_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("reservation", function (Blueprint $table) {
            $table->dropColumn("price");
        });
    }
}
