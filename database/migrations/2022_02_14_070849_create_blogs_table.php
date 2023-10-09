<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();            
            $table->text('detailed_text')->nullable();
            $table->string('image')->nullable();
            $table->enum('show_in_header', ['0','1'])->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('show_in_footer', ['0','1'])->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('category_id', ['news','article'])->comment('news, article')->nullable();
            $table->enum('is_active', ['0','1'])->default('1')->comment('0 = No, 1 = Yes')->nullable();
            $table->enum('is_delete', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
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
        Schema::dropIfExists('blogs');
    }
}
