<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string("name")->nullable();
            $table->enum('relation', ['myself', 'cousin', 'child', 'parent', 'wife', 'nephew'])->default('myself')->index();
            $table
                ->string("email")
                ->nullable()
                ->index();
            $table->date("birthdate")->nullable();
            $table->longText("image")->nullable();
            $table->tinyInteger("gender")
                ->nullable()
                ->default("0");
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
        Schema::dropIfExists('patients');
    }
}
