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
        Schema::create('plats_users', function (Blueprint $table) {
            $table->bigIncrements('p_u_id')->comment('id người dùng tự động tăng');
            $table->string('p_u_email')->unique()->comment('email');
            $table->string('p_u_password')->comment('mật khẩu');
            $table->text('p_u_fullname')->comment('họ và tên');
            $table->text('p_u_address')->comment('địa chỉ');
            $table->string('p_u_birthday')->comment('ngày,tháng,năm sinh');
            $table->string('p_u_social')->comment('đăng nhập mạng xã hội: facebook,google,apple, nếu login bình thường thì không cần');
            $table->unsignedBigInteger('p_u_created')->comment('ngày tạo tài khoản');
            $table->unsignedBigInteger('p_u_updated')->comment('ngày cập nhật tài khoản');
            $table->timestamps();
            
            // Add indexes
            $table->index('p_u_id');
            $table->index('p_u_email');
            $table->index('p_u_password');
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
