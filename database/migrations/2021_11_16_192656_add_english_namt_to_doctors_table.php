<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnglishNamtToDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("doctors", function (Blueprint $table) {
            $table
                ->json("heal_cases_en")
                ->after("heal_cases")
                ->nullable();
            $table->renameColumn("heal_cases", "heal_cases_ar");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("doctors", function (Blueprint $table) {
            $table->renameColumn("heal_cases_ar", "heal_cases");
            $table->dropColumn("heal_cases_en");
        });
    }
}
