<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('top_category', function (Blueprint $table) {
        $table->id();
        $table->string('category_name')->nullable();
        $table->string('category_icon')->nullable();
        $table->string('category_image')->nullable();
        $table->string('category_code')->nullable();
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
        Schema::dropIfExists('top_category');
    }
}
