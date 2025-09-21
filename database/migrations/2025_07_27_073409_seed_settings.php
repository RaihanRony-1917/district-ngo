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
        DB::table('settings')->updateOrInsert([
            'id' => 1,
            'site_name' => 'District Social NGO',
            'lang_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('extra_settings')->updateOrInsert([
            'id' => 1,
            'cp_text' => 'District Social NGO',
            'lang_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('donations')->updateOrInsert([
            'id' => 1,
            'lang_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
