<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("promocodes", function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->decimal("percent", 6, 3);
            $table
                ->enum("type", ["reservation", "package"])
                ->default("reservation");
            $table->dateTime("use_time")->nullable();
            $table->dateTime("expired_at")->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("promocodes");
    }
}
