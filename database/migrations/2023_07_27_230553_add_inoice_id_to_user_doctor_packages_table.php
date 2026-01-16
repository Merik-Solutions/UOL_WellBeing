<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInoiceIdToUserDoctorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_doctor_packages', function (Blueprint $table) {
            $table->string('invoice_id')->nullable()->after('expired_at');
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
            $table->dropColumn('invoice_id');
        });
    }
}
