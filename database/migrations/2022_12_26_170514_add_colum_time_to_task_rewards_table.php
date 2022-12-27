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
        Schema::table('task_rewards', function (Blueprint $table) {
            //
            $table->timestamp('time_public')->nullable();
            $table->timestamp('time_campaign')->nullable();
            $table->timestamp('time_reward')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_rewards', function (Blueprint $table) {
            //
        });
    }
};
