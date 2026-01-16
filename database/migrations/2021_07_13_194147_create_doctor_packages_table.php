<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("doctor_packages", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("doctor_id")
                ->constrained("doctors")
                ->cascadeOnDelete();
            $table
                ->foreignId("package_id")
                ->constrained("packages")
                ->cascadeOnDelete();
            $table->unsignedDecimal("price", 10, 5);
            $table->unsignedInteger("expires_in")->nullable();
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
        Schema::dropIfExists("doctor_packages");
    }
}
