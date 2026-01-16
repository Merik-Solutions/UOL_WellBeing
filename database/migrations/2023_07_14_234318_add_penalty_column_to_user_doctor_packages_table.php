<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPenaltyColumnToUserDoctorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_doctor_packages', function (Blueprint $table) {
            $table->unsignedInteger('penalty_percent')->nullable()->after('price');
            $table->unsignedInteger('price_before_penalty')->nullable()->after('penalty_percent');
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
            $table->dropColumn('penalty_percent');
            $table->dropColumn('price_before_penalty');
        });
    }
}
