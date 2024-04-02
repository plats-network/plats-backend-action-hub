<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE user_codes CHANGE COLUMN hash_code color_code VARCHAR(255)');
        DB::statement('ALTER TABLE user_codes CHANGE COLUMN task_id task_event_id CHAR(36)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE user_codes CHANGE COLUMN color_code hash_code VARCHAR(255)');
        DB::statement('ALTER TABLE user_codes CHANGE COLUMN task_event_id task_id CHAR(36)');
    }
};
