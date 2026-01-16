<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table
                ->integer('expire_in')
                ->before('min_expire_in')
                ->default('360');
            $table->dropColumn('min_expire_in');
            $table->dropColumn('max_expire_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn('expire_in');
            $table->integer('min_expire_in');
            $table->integer('max_expire_in');
        });
    }
}
