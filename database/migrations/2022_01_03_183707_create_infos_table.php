<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Blueprinteger;
use Illuminate\Support\Facades\Schema;

class CreateInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('infos')){
            Schema::create('infos', function (Blueprint $table) {
                $table->id();
            //Borrower's details
            $table->string('b_fname')->nullable();
            $table->string('b_lname')->nullable();
            $table->string('b_phone')->nullable();
            $table->string('b_email')->nullable();
            $table->string('b_address')->nullable();
            $table->string('b_suite')->nullable();
            $table->string('b_city')->nullable();
            $table->string('b_state')->nullable();
            $table->string('b_zip')->nullable();

            //Co-borrower's details
            $table->string('co_fname')->nullable();
            $table->string('co_lname')->nullable();
            $table->string('co_phone')->nullable();
            $table->string('co_email')->nullable();
            $table->string('co_address')->nullable();
            $table->string('co_suite')->nullable();
            $table->string('co_city')->nullable();
            $table->string('co_state')->nullable();
            $table->string('co_zip')->nullable();
            //Subject property address
            $table->string('p_address')->nullable();
            $table->string('p_suite')->nullable();
            $table->string('p_city')->nullable();
            $table->string('p_state')->nullable();
            $table->string('p_zip')->nullable();
            //Purchase details
            $table->string('purchase_type')->nullable();
            $table->string('company_name')->nullable();
            $table->string('purchase_purpose')->nullable();
            $table->integer('purchase_price')->nullable();
            $table->integer('purchase_dp')->nullable();
            $table->integer('loan_amount')->nullable();
            //Refinance details
            $table->integer('mortage1')->nullable();
            $table->float('interest1',11,2)->nullable();
            $table->integer('mortage2')->nullable();
            $table->float('interest2',11,2)->nullable();
            $table->integer('value')->nullable();
            $table->string('cashout')->nullable();
            $table->integer('cashout_amount')->nullable();
            $table->string('purpose')->nullable();
            $table->bigInteger('user_id');
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
        Schema::dropIfExists('infos');
    }
}
