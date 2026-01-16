<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatsTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("chats", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table
                ->foreignId("doctor_id")
                ->constrained("doctors")
                ->cascadeOnDelete();
            $table
                ->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::drop("chats");
    }
}
