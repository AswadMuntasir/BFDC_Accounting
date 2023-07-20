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
        Schema::create('voucher_entry', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_type');
            $table->string('voucher_no');
            $table->string('type');
            $table->string('type_name')->nullable();
            $table->string('type_cheque')->nullable();
            $table->string('type_date')->nullable();
            $table->date('voucher_date');
            $table->string('party')->nullable();
            $table->string('receiver')->nullable();
            $table->longText('description')->nullable();
            $table->longText('dr_amount')->nullable();
            $table->longText('cr_amount')->nullable();
            $table->integer('total_dr_amount')->nullable();
            $table->integer('total_cr_amount')->nullable();
            $table->integer('vat')->nullable();
            $table->integer('tax')->nullable();
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
        Schema::dropIfExists('voucher_entry');
    }
};
