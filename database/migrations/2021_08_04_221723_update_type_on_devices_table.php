<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTypeOnDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("devices");

        Schema::create("devices", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->morphs("notifiable");
            $table->string("user_agent");
            $table->longText("token");
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
        Schema::dropIfExists("devices");

        Schema::create("devices", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->morphs("model");
            $table->tinyInteger("device_type")->default(1);
            $table->tinyInteger("token_type")->default(1);
            $table->longText("token");
            $table->timestamps();
        });
    }
}
