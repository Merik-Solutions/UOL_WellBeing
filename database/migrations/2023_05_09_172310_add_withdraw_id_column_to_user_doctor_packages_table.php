<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWithdrawIdColumnToUserDoctorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_doctor_packages', function (Blueprint $table) {
            $table->unsignedBigInteger('withdraw_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_doctor_packages', function (Blueprint $table) {
            $table->dropColumn('withdraw_id');
        });
    }
}
