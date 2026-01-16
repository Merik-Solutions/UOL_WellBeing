<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("packages", function (Blueprint $table) {
            $table->id();
            $table->string("name_ar");
            $table->string("name_en");
            $table->longText("description_ar");
            $table->longText("description_en");
            $table->decimal("min_price", 10, 5);
            $table->decimal("max_price", 10, 5);
            $table->unsignedInteger("min_expire_in")->nullable();
            $table->unsignedInteger("max_expire_in")->nullable();
            $table->unsignedInteger("amount");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("packages");
    }
}
