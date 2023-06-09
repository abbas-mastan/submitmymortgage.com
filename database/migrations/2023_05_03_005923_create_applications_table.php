<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('applications')) {
            Schema::create('applications', function (Blueprint $table) {
                $table->id();
                // persopnal information
                $table->string('name')->nullable();
                $table->string('date')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                // property details
                $table->string('property_profile')->nullable();
                $table->string('address')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('zip')->nullable();
                $table->string('property_value')->nullable();
                $table->string('purchase_date')->nullable();
                $table->string('purchase_value')->nullable();
                $table->string('property_type')->nullable();
                $table->string('property_vested')->nullable();
                $table->string('seek_loan_amount')->nullable();
                $table->string('closing_date')->nullable();
                $table->string('loan_purpose')->nullable();
                $table->string('income_type')->nullable();
                $table->string('property_income')->nullable();
                $table->string('monthly_rental_income')->nullable();
                // existing loans
                $table->string('is_property_paid')->nullable();
                $table->string('loan_type')->nullable();
                $table->string('first_loan')->nullable();
                $table->string('first_loan_rate')->nullable();
                $table->string('first_loan_lender')->nullable();
                $table->string('second_loan')->nullable();
                $table->string('second_loan_rate')->nullable();
                $table->string('second_loan_lender')->nullable();
                $table->string('late_payments')->nullable();
                $table->string('foreclosure')->nullable();
                $table->string('liens')->nullable();
                $table->string('LTV')->nullable();
                $table->string('CLTV')->nullable();
                // employment
                $table->string('employement_status')->nullable();
                $table->string('credit_score1')->nullable();
                $table->string('credit_score2')->nullable();
                $table->string('reserves')->nullable();
                $table->string('down')->nullable();
                $table->string('additional_property')->nullable();
                $table->string('goal')->nullable();
                $table->longText('note')->nullable();
                $table->bigInteger('user_id')->constrained();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
