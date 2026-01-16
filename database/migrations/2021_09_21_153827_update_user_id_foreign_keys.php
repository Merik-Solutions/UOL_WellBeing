<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserIdForeignKeys extends Migration
{
    public $tables = [
        "chats",
        "notes",
        "prescriptions",
        "ratings",
        "reservations",
    ];
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("reservation_requests", function (Blueprint $table) {
            $table->dropForeign(["reservation_id"]);
        });
        Schema::table("reservation_requests", function (Blueprint $table) {
            $table
                ->foreign("reservation_id")
                ->on("reservations")
                ->references("id")
                ->cascadeOnDelete();
        });

        foreach ($this->tables as $table) {
            $this->addCascadeToForeign($table);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("reservation_requests", function (Blueprint $table) {
            $table->dropForeign(["reservation_id"]);
        });
        Schema::table("reservation_requests", function (Blueprint $table) {
            $table
                ->foreign("reservation_id")
                ->on("reservations")
                ->references("id");
        });

        foreach ($this->tables as $table) {
            $this->rollbackForeign($table);
        }
    }

    public function addCascadeToForeign($table_name)
    {
        Schema::table($table_name, function (Blueprint $table) {
            $table->dropForeign(["user_id"]);
        });

        Schema::table($table_name, function (Blueprint $table) {
            $table
                ->foreign("user_id")
                ->on("users")
                ->references("id")
                ->cascadeOnDelete();
        });
    }

    public function rollbackForeign($table_name)
    {
        Schema::table($table_name, function (Blueprint $table) {
            $table->dropForeign(["user_id"]);
        });
        Schema::table($table_name, function (Blueprint $table) {
            $table
                ->foreign("user_id")
                ->on("users")
                ->references("id");
        });
    }
}
