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
        Schema::create('collection_entry', function (Blueprint $table) {
            $table->id();
            $table->date('collection_date');
            $table->string('bill_section');
            $table->string('customer_name');
            $table->string('collection_type');
            $table->string('type_name')->nullable();
            $table->string('type_cheque')->nullable();
            $table->string('type_date')->nullable();
            $table->integer('collection_amount');
            $table->longText('description')->nullable();
            $table->longText('dr_amount')->nullable();
            $table->longText('cr_amount')->nullable();
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
        Schema::dropIfExists('collection_entry');
    }
};
