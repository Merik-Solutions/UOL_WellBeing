<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWalletAndOnlineColumnToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table(table: 'reservations', callback: function (Blueprint $table) {
            $table->string('wallet')->after('status')->default(0);
            $table->string('online')->after('wallet')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(table: 'reservations', callback: function (Blueprint $table) {
            $table->dropColumn('wallet', 'online');
        });
    }
}
