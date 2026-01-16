<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("doctors", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name");
            $table->string("title_ar")->nullable();
            $table->string("title_en")->nullable();
            $table->longText("description_ar")->nullable();
            $table->longText("description_en")->nullable();

            $table->string("email");
            $table->string("password");
            $table->string("phone");
            $table->string("expirence")->nullable();
            $table
                ->foreignId("category_id")
                ->nullable()
                ->constrained("categories")
                ->onDelete("SET NULL");
            $table->json("heal_cases")->nullable();
            $table->char("price")->nullable();
            $table
                ->tinyInteger("period")
                ->unsigned()
                ->nullable();
            $table
                ->smallInteger("verification_code")
                ->unique()
                ->unsigned()
                ->nullable();

            $table->rememberToken();
            $table->tinyInteger("gender")->default("0");
            $table->longText("image")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::drop("doctors");
    }
}
