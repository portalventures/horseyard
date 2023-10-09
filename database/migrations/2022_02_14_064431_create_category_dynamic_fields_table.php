<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryDynamicFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_dynamic_fields', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('field_name')->nullable();
            $table->integer('field_seq_no')->nullable();
            $table->string('field_type')->nullable();
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
        Schema::dropIfExists('category_dynamic_fields');
    }
}
