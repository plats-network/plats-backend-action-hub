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
        Schema::create('user_task_rewards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->index()->comment('');
            $table->uuid('detail_reward_id')->index()->comment('');
            $table->boolean('is_consumed')->default(false)->comment('false: Chưa dùng, true: Đã dùng');
            $table->dateTimeTz('consume_at', $precision = 0)->nullable()->comment('Thời gian dùng Y-m-d H-i:s');
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
        Schema::dropIfExists('user_task_rewards');
    }
};
