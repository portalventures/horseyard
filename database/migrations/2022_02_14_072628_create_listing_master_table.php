<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('listing_master', function (Blueprint $table) {
        $table->id()->index();
        $table->integer('category_id')->nullable();
        $table->integer('user_id')->nullable();
        
        $table->double('price', 18, 2)->nullable();
        $table->enum('item_show_type', ['free','negotiable', 'ONO'])->comment('free, negotiable , ONO')->nullable();

        $table->string('country_id')->nullable();
        $table->string('state_id')->nullable();
        $table->string('suburb_id')->nullable();
        $table->string('pic_number')->nullable();

        $table->string('title')->nullable();
        $table->text('description')->nullable();

        /*horse*/
          $table->string('horse_name')->nullable();
          $table->string('horse_registration_no')->nullable();
          $table->string('sire')->nullable();
          $table->string('dam')->nullable();

        /*Transport*/
          $table->string('make')->nullable();
          $table->string('transport_model')->nullable();
          $table->string('year')->nullable();
          $table->string('kms')->nullable();
          $table->string('vehicle_registration_number')->nullable();
        
        /*Saddlery*/
          $table->string('brand')->nullable();
          $table->string('saddlery_model')->nullable();
        
        /*Property*/
          $table->string('land_size')->nullable();         
          $table->string('property_category')->nullable();

        $table->string('featured_image_url')->nullable();
        $table->string('video_url')->nullable();

        $table->string('contact_name')->nullable();
        $table->string('contact_number')->nullable();
        $table->string('contact_email')->nullable();
        
        $table->enum('is_active', ['0','1'])->default('1')->comment('0 = No, 1 = Yes')->nullable();
        $table->enum('is_approved', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->enum('is_blocked', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->enum('is_delete', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->timestamp('blocked_dt')->nullable();
        $table->timestamp('approval_dt')->nullable();

        $table->string('slug')->nullable();
        $table->string('identification_code')->nullable();
        $table->string('ad_id')->nullable();

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
        Schema::dropIfExists('listing_master');
    }
}
