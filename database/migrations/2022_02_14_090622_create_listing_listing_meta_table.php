<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingListingMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_meta', function (Blueprint $table) {
            $table->id();
            $table->integer('listing_master_id')->nullable();
            $table->integer('number_of_views')->nullable();
            $table->string('image_name')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamp('last_view_dt')->nullable();
            $table->timestamp('last_edited_dt')->nullable();
            $table->timestamp('listing_dt')->nullable();
            $table->timestamp('last_meta_update_dt')->nullable();
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
        Schema::dropIfExists('listing_listing_meta');
    }
}
