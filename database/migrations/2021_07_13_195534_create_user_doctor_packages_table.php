<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDoctorPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create("user_doctor_packages", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("user_id")
                ->constrained("users")
                ->cascadeOnDelete();
            $table
                ->foreignId("doctor_id")
                ->constrained("doctors")
                ->cascadeOnDelete();
            $table
                ->foreignId("package_id")
                ->constrained("packages")
                ->cascadeOnDelete();
            $table
                ->foreignId("promocode_id")
                ->nullable()
                ->constrained("promocodes")
                ->nullOnDelete();
            $table->decimal("value_id", 10, 5)->nullable();
            $table
                ->foreignId("doctor_package_id")
                ->constrained("doctor_packages")
                ->cascadeOnDelete();
            $table->dateTime("expired_at");
            $table->unsignedDecimal("price", 10, 5);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("patient_doctor_packages");
    }
}
