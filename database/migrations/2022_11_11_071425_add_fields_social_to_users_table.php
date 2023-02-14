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
        Schema::table('users', function (Blueprint $table) {
            $table->string('twitter')->nullable()->comment('Link đến tài khoản twitter');
            $table->string('facebook')->nullable()->comment('Link đến tài khoản facebook');
            $table->string('discord')->nullable()->comment('Link đến tài khoản discord');
            $table->string('telegram')->nullable()->comment('Link đến tài khoản telegram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
