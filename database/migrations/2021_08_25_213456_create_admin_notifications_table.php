<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("admin_notifications", function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable();
            $table->string("body")->nullable();
            $table->boolean("user_types")->nullable();
            $table->json("doctors")->nullable();
            $table->json("users")->nullable();
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
        Schema::dropIfExists("admin_notifications");
    }
}
