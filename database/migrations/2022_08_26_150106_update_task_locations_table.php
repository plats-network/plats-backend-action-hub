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
        Schema::table('task_locations', function (Blueprint $table) {
            $table->string('phone_number')->nullable()->after('status')->comment('Phone number at this location');
            $table->string('open_time')->nullable()->after('status')->comment('Opening hours at this location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
