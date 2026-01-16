<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeReservatioIdNullableAtPrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("prescriptions", function (Blueprint $table) {
            $table
                ->unsignedBigInteger("reservation_id")
                ->nullable()
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("prescriptions", function (Blueprint $table) {
            $table
                ->unsignedBigInteger("reservation_id")
                ->nullable(false)
                ->change();
        });
    }
}
