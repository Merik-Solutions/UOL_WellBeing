<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("transactions", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->nullableMorphs("billable");
            $table
                ->foreignId("doctor_id")
                ->nullable()
                ->constrained("doctors");
            $table
                ->foreignId("user_id")
                ->nullable()
                ->constrained("users");
            $table->string("gateway")->default("hyperpay");
            $table->decimal("amount", 10, 4);
            $table->char("currency")->nullable();
            $table
                ->string("transaction_id")
                ->nullable()
                ->index();
            $table->char("card_brand")->nullable();
            $table->char("card_first_six_digits")->nullable();
            $table->char("card_last_four_digits")->nullable();
            $table->smallInteger("response_code")->nullable();
            //my columns
            $table->morphs("model");
            $table
                ->smallInteger("payment_type")
                ->index()
                ->default(1); //0=>debut ,1=>credit

            $table->longText("description")->nullable();

            $table
                ->unsignedBigInteger("credit_transaction_id")
                ->nullable()
                ->index();

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
        Schema::dropIfExists("transactions");
    }
}
