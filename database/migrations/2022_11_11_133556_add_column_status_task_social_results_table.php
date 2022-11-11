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
        Schema::table('task_social_results', function (Blueprint $table) {
            $table->string('status')->default(0)->after('task_social_id')->comment('0: Not done, 1: In progress, 2: Done. 3: Failed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_social_results', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
