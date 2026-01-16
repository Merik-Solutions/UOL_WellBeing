<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePasswordOnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("users", function (Blueprint $table) {
            $table
                ->string("password")
                ->nullable()
                ->change();
            $table
                ->string("email")
                ->nullable()
                ->change();
            $table->string("phone")->change();
            $table
                ->string("code")
                ->index()
                ->after("phone")
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->dropIndex(["code"]);
            $table->dropColumn("code");
            $table
                ->string("password")
                ->nullable()
                ->change();
            $table->string("email")->change();
            $table
                ->string("phone")
                ->nullable()
                ->change();
        });
    }
}
