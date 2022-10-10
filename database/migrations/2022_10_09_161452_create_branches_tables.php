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
        Schema::create('branches', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('company_id')->index()->comment('');
            $table->string('name')->nullable()->comment('Tên chi nhánh, cửa hàng...');
            $table->string('address')->nullable()->comment('Địa chỉ cửa hàng');
            $table->string('phone')->nullable()->comment('Số điện thoại');
            $table->string('hotline')->nullable()->comment('');
            $table->string('open_time')->nullable()->comment('');
            $table->string('close_time')->nullable()->comment('');
            $table->string('work_today')->nullable()->comment();
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
        Schema::dropIfExists('branches');
    }
};
