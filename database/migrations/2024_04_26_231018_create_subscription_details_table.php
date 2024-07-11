<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('stripe_subscription_id')->nullable();
            $table->string('stripe_subscription_schedule_id')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('subscription_plan_price_id')->nullable();
            $table->float('plan_amount',10,2)->nullable();
            $table->string('plan_amount_currency')->nullable();
            $table->string('plan_interval')->nullable();
            $table->string('plan_interval_count')->nullable();
            $table->timestamp('plan_starts_at')->nullable();
            $table->timestamp('plan_end_at')->nullable();
            $table->timestamp('created')->nullable();
            $table->string('trial_end')->nullable();
            $table->boolean('cancel')->default(false);
            $table->enum('status',['active','cancelled'])->nullable();
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
        Schema::dropIfExists('subscription_details');
    }
}
