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
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('mission_id')->index();
            $table->string('name');
            $table->mediumText('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('reward_amount', 12)->default(0);
            $table->unsignedBigInteger('exc_time')->default(0);
            $table->string('long')->nullable();;
            $table->string('last')->nullable();;
            $table->uuid('creator_id')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('tasks');
    }
};
