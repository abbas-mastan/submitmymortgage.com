<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('media')) {
            Schema::create('media', function (Blueprint $table) {
                $table->id();
                $table->string("file_name");
                $table->string("file_path");
                $table->decimal("file_size", 11, 2);
                $table->string("file_type");
                $table->string("file_extension");
                $table->string("category")->nullable();
                $table->string("status")->nullable()->comment("Can take values 'Complete' and 'Incomplete' or 'NULL'");
                $table->text("comments")->nullable();
                $table->text("cat_comments")->nullable();
                $table->text("user_cat_comments")->nullable();
                $table->bigInteger("user_id")->nullable();
                $table->bigInteger("uploaded_by")->nullable();
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
        Schema::dropIfExists('media');
    }
}
