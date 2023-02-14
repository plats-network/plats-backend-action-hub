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
            $table->integer('gender')->after('email_verified_at')->nullable()->comment('0: Nam, 1: Nu, 2: Khac');
            $table->date('birth')->after('gender')->nullable()->comment('năm sinh');
            $table->string('avatar_path')->after('birth')->nullable()->comment('ảnh đại diện');
            $table->boolean('check_avatar')->after('avatar_path')->default(false)->comment('duyện ảnh đại diện');
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
