<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_messages', function (Blueprint $table) {
            $table->id();            
            $table->integer('parent_msg_id')->nullable();
            $table->integer('from_user_id')->nullable();
            $table->integer('to_user_id')->nullable();
            $table->text('subject')->nullable();
            $table->text('body_text')->nullable();
            $table->timestamp('date_of_msg')->nullable();
            $table->enum('is_read', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('is_active', ['0','1'])->default('1')->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('is_draft', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
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
        Schema::dropIfExists('customer_messages');
    }
}
