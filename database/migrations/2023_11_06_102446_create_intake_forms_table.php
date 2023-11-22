<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntakeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intake_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('address');
            $table->string('phone');
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('loan_type')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('property_value')->nullable();
            $table->string('down_payment')->nullable();
            $table->string('current_loan_amount')->nullable();
            $table->string('closing_date')->nullable();
            $table->string('current_lender')->nullable();
            $table->string('rate')->nullable();
            $table->string('is_it_rental_property')->nullable();
            $table->string('monthly_rental_income')->nullable();
            $table->string('cashout_amount')->nullable();
            $table->string('is_repair_finance_needed')->nullable();
            $table->string('how_much')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('intake_forms');
    }
}
