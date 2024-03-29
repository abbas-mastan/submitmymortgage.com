<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_categories')) {
            Schema::create('user_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('user_categories');
    }
}
