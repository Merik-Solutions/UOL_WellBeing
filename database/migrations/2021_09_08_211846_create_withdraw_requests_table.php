<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("withdraw_requests", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("doctor_id")
                ->nullable()
                ->constrained("doctors")
                ->nullOnDelete();
            $table->decimal("amount", "10", 5);
            $table
                ->enum("status", ["waiting", "accepted", "refused"])
                ->default("waiting");
            $table->timestamp("answered_by")->nullable();
            $table
                ->foreignId("transaction_id")
                ->nullable()
                ->constrained("transactions");
            $table->longText("notes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("withdraw_requests");
    }
}
