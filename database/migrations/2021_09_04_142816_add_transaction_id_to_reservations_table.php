<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionIdToReservationsTable extends Migration
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
                ->foreignId("transaction_id")
                ->after("user_id")
                ->nullable()
                ->constrained("transactions", "id")
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
        Schema::table("reservations", function (Blueprint $table) {
            $table->dropForeign(["transaction_id"]);
            $table->dropColumn("transaction_id");
        });
    }
}
