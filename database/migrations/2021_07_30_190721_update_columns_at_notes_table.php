<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnsAtNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("notes");
        Schema::create("notes", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table
                ->foreignId("doctor_id")
                ->constrained("doctors")
                ->cascadeOnDelete();
            $table
                ->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete();
            $table->string("title")->nullable();
            $table->longText("description")->nullable();
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
        Schema::dropIfExists("notes");
        Schema::create("notes", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("doctor_id")
                ->constrained("doctors")
                ->cascadeOnDelete();
            $table
                ->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete();
            $table->string("medical_histroy")->nullable();
            $table->string("dignosis")->nullable();
            $table->longText("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
