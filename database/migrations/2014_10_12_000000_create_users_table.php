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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->tinyInteger('role')->default(USER_ROLE);
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->char('confirmation_code', 6)->after('email_verified_at')->nullable();
            $table->string('twitter')->nullable()->comment('Link đến tài khoản twitter');
            $table->string('facebook')->nullable()->comment('Link đến tài khoản facebook');
            $table->string('discord')->nullable()->comment('Link đến tài khoản discord');
            $table->string('telegram')->nullable()->comment('Link đến tài khoản telegram');
            $table->integer('gender')->after('email_verified_at')->nullable()->comment('0: Nam, 1: Nu, 2: Khac');
            $table->date('birth')->after('gender')->nullable()->comment('năm sinh');
            $table->string('avatar_path')->after('birth')->nullable()->comment('ảnh đại diện');
            $table->boolean('check_avatar')->after('avatar_path')->default(false)->comment('duyện ảnh đại diện');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
};
