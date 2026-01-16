<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditStatusOnReservationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `reservation_requests`
        CHANGE COLUMN `status` `status` ENUM('pending', 'canceled', 'confirmed') NOT NULL ;
        ");
        Schema::table("reservation_requests", function (Blueprint $table) {
            $table
                ->dateTime("changed_at")
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
        DB::statement("ALTER TABLE `reservation_requests`
        CHANGE COLUMN `status` `status` ENUM('pending', 'cancled', 'confimred') NOT NULL ;
        ");

        Schema::table("reservation_requests", function (Blueprint $table) {
            $table->dateTime("changed_at")->change();
        });
    }
}
