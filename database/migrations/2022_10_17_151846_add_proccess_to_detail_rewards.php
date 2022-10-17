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
        Schema::table('detail_rewards', function (Blueprint $table) {
            $table->boolean('proccess')->default(false)->comment('flase: chưa xử lý, true: đã xử lý');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_rewards', function (Blueprint $table) {
            //
        });
    }
};
