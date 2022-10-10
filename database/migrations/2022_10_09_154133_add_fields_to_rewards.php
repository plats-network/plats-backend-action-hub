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
        Schema::table('rewards', function (Blueprint $table) {
            $table->integer('type')->default(0)->comment('0: Không biến thể, 1: Có biến thể')->after('name');
            $table->integer('region')->default(0)->comment('0: tất cả, 1: bắc, 2: trung, 3: nam');
            $table->date('start_at')->nullable()->comment('thời gian bắt đầu chiến dịch');
            $table->date('end_at')->nullable()->comment('thời gian kết thúc chiến dịch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rewards', function (Blueprint $table) {
            //
        });
    }
};
