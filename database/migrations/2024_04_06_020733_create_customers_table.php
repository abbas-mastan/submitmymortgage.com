<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trials', function (Blueprint $table) {
            $table->id();
            // $table->string('full_name');
            // $table->string('email')->unique();
            $table->string('address');
            $table->string('phone');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('postal_code');
            $table->string('customer_id');
            $table->integer('login_sequence')->default(0);
            $table->timestamp('trial_started_at');
            $table->timestamp('subscribed_at')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
