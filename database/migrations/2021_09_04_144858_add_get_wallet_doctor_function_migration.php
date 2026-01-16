<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddGetWalletDoctorFunctionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("DROP function IF EXISTS `GetDoctorWallet`;");
        DB::unprepared("CREATE  FUNCTION `GetDoctorWallet`(_doctor_id BIGINT(20)) RETURNS decimal(10,5)
                DETERMINISTIC
        BEGIN
            DECLARE receive decimal (10,5) default 0;
            DECLARE send 	decimal (10,5) default 0;

       SELECT sum(amount)into send from transactions
           where sender_type='App\\\\Models\\\\Doctor'
           and sender_id=_doctor_id
           group by sender_type,sender_id
           limit 1 ;

	  SELECT sum(amount)into receive from
           transactions
           left join reservations on reservations.transaction_id = transactions.id
           where receiver_type='App\\\\Models\\\\Doctor'
           and receiver_id=_doctor_id
           and(reservations.status ='finished' or reservations.status is null)
           group by receiver_type,receiver_id
           limit 1;
       RETURN  receive - send ;
       END");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP function IF EXISTS `GetDoctorWallet`;");
    }
}
