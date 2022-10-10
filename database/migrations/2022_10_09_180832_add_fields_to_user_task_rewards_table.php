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
        Schema::table('user_task_rewards', function (Blueprint $table) {
            $table->integer('type')->default(0)->comment('0: tokens, 1: NFTs, 2: Vouchers, 3: boxs, 4: Wallet ')->after('consume_at');
            $table->integer('amount')->nullable()->comment('')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_task_rewards', function (Blueprint $table) {
            //
        });
    }
};
