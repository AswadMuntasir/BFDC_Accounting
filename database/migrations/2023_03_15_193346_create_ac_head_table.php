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
        Schema::create('ac_head', function (Blueprint $table) {
            $table->id();
            $table->string('control_ac_id');
            $table->string('ac_head_id');
            $table->string('ac_head_name_eng');
            $table->string('ac_head_name_ben');
            $table->decimal('opening_balance', 10, 2)->default(0.00);
            $table->string('opening_balance_type');
            $table->date('initialization_date');
            $table->string('is_ugc_ac_head');
            $table->string('is_status');
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
        Schema::dropIfExists('ac_head');
    }
};
