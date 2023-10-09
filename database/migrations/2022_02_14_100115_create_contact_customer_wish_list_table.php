<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactCustomerWishListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('contact_customer_wish_list', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id')->nullable();
        $table->integer('listing_master_id')->nullable();
        $table->enum('is_active', ['0','1'])->default('1')->comment('0 = No, 1 = Yes')->nullable();
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
        Schema::dropIfExists('contact_customer_wish_list');
    }
}
