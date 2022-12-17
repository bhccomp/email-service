<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_emails_config', function (Blueprint $table) {
            
            $table->id();
            $table->string('user_id');
            $table->string('name');
            $table->string('address');
            $table->string('driver');
            $table->string('host');
            $table->string('port');
            $table->string('encryption');
            $table->string('username');
            $table->string('password');
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
        Schema::dropIfExists('user_emails_config');
    }
};
