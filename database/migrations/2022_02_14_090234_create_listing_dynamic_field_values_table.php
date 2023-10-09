<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingDynamicFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listing_dynamic_field_values', function (Blueprint $table) {
            $table->id();
            $table->integer('listing_master_id')->nullable()->index();
            $table->integer('field_id')->nullable();
            $table->integer('dynamic_field_id')->nullable();
            $table->string('field_value')->nullable();            
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
        Schema::dropIfExists('listing_dynamic_field_values');
    }
}
