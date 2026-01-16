<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table
                ->unsignedBigInteger('doctor_id')
                ->nullable()
                ->change();
        });
        Schema::table('reservations', function (Blueprint $table) {
            $table
                ->foreign('doctor_id')
                ->on('doctors')
                ->references('id')
                ->cascadeOnDelete();
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
