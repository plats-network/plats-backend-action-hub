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
        Schema::create('task_socials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('task_id');
            $table->tinyInteger('type')->default(0)->comment('0. Follow/Like(Page FB), 1. Share/Retweet, 2. Tweet/Post, 3. Join(Discord, Telegram)');
            $table->string('url')->comment('Url for type social task');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['task_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_socials');
    }
};
