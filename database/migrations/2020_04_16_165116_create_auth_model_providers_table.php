<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthModelProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("auth_model_providers", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->morphs("model");
            $table->string("provider");
            $table->longText("token")->nullable();
            $table->longText("expires_in")->nullable();
            $table->longText("refresh_token")->nullable();
            $table->longText("token_secret")->nullable();
            $table->string("provider_id")->nullable();
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
        Schema::dropIfExists("auth_model_providers");
    }
}
