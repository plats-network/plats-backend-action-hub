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
        Schema::create('code_vouchers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('type')->default(0)->comment('30shine, Quán Ốc, Achicklet');
            $table->string('code')->nullable()->comment('Mã vouchers');
            $table->boolean('status')->default(false)->comment('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('code_vouchers');
    }
};
