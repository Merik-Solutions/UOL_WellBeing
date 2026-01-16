<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create("categories", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name_ar")->nullable();
            $table->string("name_en")->nullable();
            $table->longText("image")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop("categories");
    }
}
