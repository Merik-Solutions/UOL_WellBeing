<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRelationsAtRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     Schema::table('ratings',function (Blueprint $table){

         $table->dropForeign(['doctor_id']);
         $table->dropForeign(['reservation_id']);
         $table
             ->foreignId('doctor_id')
             ->change()
             ->constrained('doctors')
             ->cascadeOnDelete()
             ;  $table
             ->foreignId('reservation_id')
             ->change()
             ->constrained('reservations')
             ->cascadeOnDelete()
             ;

     });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
