<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
       DB::table('users')->updateOrInsert(
            ['id' => 1], // Look for a user with ID = 1
            [
                'name' => 'Codexaa Admin',
                'email' => 'demo@gmail.com',
                'password' => Hash::make('demo@gmail.com@123'), // Use Hash::make()
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
