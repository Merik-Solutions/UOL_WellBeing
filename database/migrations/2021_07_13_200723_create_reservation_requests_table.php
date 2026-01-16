<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("reservation_requests", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("reservation_id")
                ->constrained("reservations")
                ->cascadeOnDelete();
            $table->date("date");
            $table->time("from_time");
            $table->time("to_time");
            $table->enum("status", ["pending", "cancled", "confimred"]);
            $table->timestamp("changed_at");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("reservation_requests");
    }
}
