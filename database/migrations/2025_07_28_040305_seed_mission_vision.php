<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        DB::table('missions')->updateOrInsert(
            ['id' => 1], // Look for a user with ID = 1
            [
                'title' => 'Mission Title',
                'lang_id' => 1,
                'content' => 'some content',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        DB::table('visions')->updateOrInsert(
            ['id' => 1], // Look for a user with ID = 1
            [
                'title' => 'Vision Title',
                'lang_id' => 1,
                'content' => 'some content',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
