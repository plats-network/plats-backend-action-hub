<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plats_users', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('id người dùng tự động tăng');
            $table->string('email')->unique()->comment('email');
            $table->string('password')->comment('mật khẩu');
            $table->string('fullname')->nullable()->comment('họ và tên');
            $table->string('address')->nullable()->comment('địa chỉ');
            $table->string('birthday')->nullable()->comment('ngày,tháng,năm sinh');
            $table->string('social')->nullable()->comment('đăng nhập mạng xã hội: facebook,google,apple, nếu login bình thường thì không cần');
            $table->boolean('active')->default(0)->comment('0: unactive, 1: active');
            $table->string('verify_code', 255)->nullable()->comment('verify code for user');
            $table->unsignedBigInteger('created')->nullable()->comment('ngày tạo tài khoản');
            $table->unsignedBigInteger('updated')->nullable()->comment('ngày cập nhật tài khoản');
            $table->timestamps();

            // Add indexes
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plats_users');
    }
};
