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
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('reward_amount');
            $table->integer('valid_radius')->default(1)->after('duration')->comment('Valid maximum checkin radius');
            $table->integer('valid_amount')->default(1)->after('duration')->comment('The minimum amount to be achieved, for example with task check in, location check 2/3');
            $table->string('order')->default(1)->after('duration')->comment('Do the tasks in order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //
        });
    }
};
