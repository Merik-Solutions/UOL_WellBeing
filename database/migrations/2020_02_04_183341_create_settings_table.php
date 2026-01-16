<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create("settings", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->string("slug_ar");
            $table->string("slug_en");
            $table->longText("value");
            $table->tinyInteger("input_type");
            $table->tinyInteger("category");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("settings");
    }
}
