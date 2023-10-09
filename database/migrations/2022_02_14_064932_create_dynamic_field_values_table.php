<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('dynamic_field_values', function (Blueprint $table) {
        $table->id();
        $table->integer('field_id')->nullable();
        $table->string('field_value')->nullable();
        $table->string('slug')->nullable();
        $table->string('field_text')->nullable();
        $table->string('field_comment')->nullable();
        $table->integer('seq_no')->nullable();        
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
      Schema::dropIfExists('dynamic_field_values');
    }
}
