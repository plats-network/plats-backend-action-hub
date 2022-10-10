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
        Schema::create('task_guides', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('task_id')->index()->comment('');
            $table->string('url_image')->nullable()->comment('');
            $table->integer('order_num')->default(1)->comment('Thứ tự hiển thị');
            $table->boolean('status')->default(true)->comment('false: hidden, true: show');
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
        Schema::dropIfExists('task_guides');
    }
};
