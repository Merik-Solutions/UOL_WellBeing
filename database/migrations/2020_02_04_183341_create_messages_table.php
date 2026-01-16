<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("messages", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table
                ->bigInteger("chat_id")
                ->unsigned()
                ->index();
            $table->longText("message")->nullable();
            $table->morphs("sender");
            $table->timestamp("seen_at")->nullable();
            $table
                ->foreignId("user_doctor_packages_id")
                ->nullable()
                ->constrained("user_doctor_packages")
                ->onDelete("SET NULL");
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        Schema::drop("messages");
    }
}
