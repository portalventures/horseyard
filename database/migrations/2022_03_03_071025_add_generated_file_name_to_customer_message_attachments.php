<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeneratedFileNameToCustomerMessageAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_message_attachments', function (Blueprint $table) {
            $table->string('generated_file_name')->after('file_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_message_attachments', function (Blueprint $table) {
            $table->dropColumn('generated_file_name');
        });
    }
}
