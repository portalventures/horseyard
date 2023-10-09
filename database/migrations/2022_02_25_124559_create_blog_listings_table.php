<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_listings', function (Blueprint $table) {
        $table->id();
        $table->integer('created_by')->nullable();
        $table->integer('blog_id')->nullable();
        $table->string('category_id')->nullable();
        $table->integer('seq_no')->nullable();
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
        Schema::dropIfExists('blog_listings');
    }
}
