<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedInteger('penalty_percent')->nullable()->after('price');
            $table->unsignedInteger('price_before_penalty')->nullable()->after('penalty_percent');
            $table->unsignedInteger('invoice_id')->nullable()->after('price_before_penalty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('penalty_percent');
            $table->dropColumn('price_before_penalty');
            $table->dropColumn('invoice_id');
        });
    }
}
