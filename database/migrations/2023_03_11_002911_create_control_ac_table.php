<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_ac', function (Blueprint $table) {
            $table->id();
            $table->string('accounts_group');
            $table->string('subsidiary_account_name');
            $table->string('account_id');
            $table->string('account_name');
            $table->string('ugc_priority');
            $table->string('is_ugc_control_ac');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('control_ac');
    }
};
