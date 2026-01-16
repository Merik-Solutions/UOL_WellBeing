<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToComplaintOrFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complaint_or_feedback', function (Blueprint $table) {
            $table->renameColumn('reservation_id','disputed_id');
            $table->string('disputed_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaint_or_feedback', function (Blueprint $table) {
            $table->dropColumn('disputed_type');
        });
    }
}
