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
        Schema::table('task_socials', function (Blueprint $table) {
            $table->string('name')->after('task_id');
            $table->tinyInteger('platform')->default(1)->after('url')->comment('1: Twitter, 2: Facebook, 3: Discord, 4: Telegram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_socials', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('platform');
        });
    }
};
