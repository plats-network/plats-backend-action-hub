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
        Schema::create('box_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->comment('');
            $table->uuid('box_id')->comment('');
            $table->boolean('is_unbox')->default(false)->comment('Trang thai mo hop qua');
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
        Schema::dropIfExists('box_users');
    }
};
