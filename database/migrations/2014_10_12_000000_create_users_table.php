<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('old_user_id')->nullable();
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('email')->unique();
        $table->string('password')->nullable();
        
        $table->string('company_name')->nullable();
        $table->string('address_line_1')->nullable();
        $table->string('address_line_2')->nullable();
        $table->string('suburb')->nullable();
        $table->string('state')->nullable();
        $table->string('country')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('phone_number')->nullable();
        $table->enum('gender', ['male','female'])->comment('male, female')->nullable();
        $table->timestamp('date_of_birth')->nullable();

        $table->string('google_id')->nullable();
        $table->string('social_type')->nullable();
        $table->string('verification_code', 25)->nullable();
        $table->enum('role', ['superadmin','admin', 'user'])->comment('superadmin, admin, user')->nullable();
        $table->enum('is_verifed', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->enum('is_active', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->enum('is_blocked', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->enum('is_delete', ['0','1'])->default('0')->comment('0 = No, 1 = Yes')->nullable();
        $table->timestamp('blocked_at')->nullable();
        $table->string('token')->nullable();
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
        Schema::dropIfExists('users');
    }
}
