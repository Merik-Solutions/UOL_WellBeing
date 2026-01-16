<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPatientIdToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->foreignId('patient_id')->after('user_id')->nullable()->constrained('patients')->nullOnDelete();
        });
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('user_id')->constrained('patients')->nullOnDelete();
        });
        Schema::table('ratings', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('user_id')->constrained('patients')->nullOnDelete();
        });
        Schema::table('user_doctor_packages', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('user_id')->constrained('patients')->nullOnDelete();
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('user_id')->constrained('patients')->nullOnDelete();
        });
        Schema::table('chats', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->after('user_id')->constrained('patients')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
        Schema::table('prescriptions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
        Schema::table('ratings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
        Schema::table('user_doctor_packages', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
        Schema::table('notes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
        Schema::table('chats', function (Blueprint $table) {
            $table->dropConstrainedForeignId('patient_id');
        });
    }
}
