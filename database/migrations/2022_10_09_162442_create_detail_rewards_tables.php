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
        Schema::create('detail_rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id')->index()->comment('');
            $table->uuid('reward_id')->index()->comment('');
            $table->integer('type')->default(0)->comment('0: token plats, 1: vouchers 30shine, 2: vouchers xem phim, 3: thẻ điện thoại');
            $table->integer('amount')->nullable()->comment('Nếu type = 0 thì có giá trị ko thì null');
            $table->string('name')->nullable()->comment();
            $table->text('description')->nullable()->comment('Mô tả');
            $table->string('url_image')->nullable()->comment('ảnh banner');
            $table->string('qr_code')->nullable()->comment('Mã qr_code uniq');
            $table->boolean('status')->default(true)->comment('Trạng thái mã: true -> active, false -> disable');
            $table->dateTime('start_at')->nullable()->comment('Thời gian bắt đầu hiệu lực');
            $table->dateTime('end_at')->nullable()->comment('Thời gian hết hạn');
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
        Schema::dropIfExists('detail_rewards');
    }
};
