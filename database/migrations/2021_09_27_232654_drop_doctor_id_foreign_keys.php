<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropDoctorIdForeignKeys extends Migration
{
    public $tables = ["doctor_packages", "schedules"];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("doctors", function (Blueprint $table) {
            $table->date("birthdate")->nullable();
        });
        Schema::table("reservations", function (Blueprint $table) {
            $table->dropForeign(["schedule_id"]);
        });
        Schema::table("reservations", function (Blueprint $table) {
            $table
                ->foreign("schedule_id")
                ->on("schedules")
                ->references("id")
                ->cascadeOnDelete();
        });
        Schema::table("prescriptions", function (Blueprint $table) {
            $table->dropForeign(["reservation_id"]);
        });
        Schema::table("prescriptions", function (Blueprint $table) {
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
        Schema::table("doctors", function (Blueprint $table) {
            $table->dropColumn("birthdate");
        });
        Schema::table("reservations", function (Blueprint $table) {
            $table->dropForeign(["schedule_id"]);
        });

        Schema::table("reservations", function (Blueprint $table) {
            $table
                ->foreign("schedule_id")
                ->on("schedules")
                ->references("id");
        });

        Schema::table("prescriptions", function (Blueprint $table) {
            $table->dropForeign(["reservation_id"]);
        });
        Schema::table("prescriptions", function (Blueprint $table) {
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
            $table->dropForeign(["doctor_id"]);
        });

        Schema::table($table_name, function (Blueprint $table) {
            $table
                ->foreign("doctor_id")
                ->on("doctors")
                ->references("id")
                ->cascadeOnDelete();
        });
    }

    public function rollbackForeign($table_name)
    {
        Schema::table($table_name, function (Blueprint $table) {
            $table->dropForeign(["doctor_id"]);
        });
        Schema::table($table_name, function (Blueprint $table) {
            $table
                ->foreign("doctor_id")
                ->on("doctors")
                ->references("id");
        });
    }
}
