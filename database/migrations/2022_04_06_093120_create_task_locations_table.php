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
        Schema::create('task_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('task_id')->index();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('task_locations');
    }
};
