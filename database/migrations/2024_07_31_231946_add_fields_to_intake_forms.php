<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToIntakeForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            $table->enum('finance_type', ["Purchase", "Cash Out", "Fix & Flip","Refinance"])->after('zip');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade')->after("user_id");
            $table->enum('borrower_employment', ["Self-Employed", "Wage Earner", "Retired"])->after('loan_type');
            $table->string('borrower_yearly_income')->after("borrower_employment");
            $table->string('address_two')->after("address")->nullable();
            $table->string('borrower_credit_score')->after("borrower_yearly_income");
            $table->string('co_borrower_name')->nullable()->after("borrower_credit_score");
            $table->string('co_borrower_email')->nullable()->after("co_borrower_name");
            $table->string('co_borrower_phone')->nullable()->after("co_borrower_email");
            $table->enum('co_borrower_employment', ["Self-Employed", "Wage Earner", "Retired"])->nullable()->after('co_borrower_phone');
            $table->string('co_borrower_yearly_income')->nullable()->after("co_borrower_employment");
            $table->string('co_borrower_credit_score')->nullable()->after("co_borrower_yearly_income");
            $table->string('verified')->default(false)->after("status");
            $table->enum('property_type', ["Single Family Residence", "Multi-Unit Residential", "Multi-Unit Building", "Commercial Property"])->after('loan_type')->nullable();
            $table->enum('property_profile', ["Primary", "Investment"])->after('property_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            $table->dropColumn('finance_type');
            $table->dropColumn('borrower_employment');
            $table->dropColumn('borrower_yearly_income');
            $table->dropColumn('borrower_credit_score');
            $table->dropColumn('co_borrower_name');
            $table->dropColumn('co_borrower_email');
            $table->dropColumn('co_borrower_phone');
            $table->dropColumn('co_borrower_employment');
            $table->dropColumn('co_borrower_yearly_income');
            $table->dropColumn('co_borrower_credit_score');
            $table->dropColumn('property_type');
            $table->dropColumn('property_profile');
            $table->dropColumn('verified');
            $table->dropColumn('created_by');
        });
    }
}
