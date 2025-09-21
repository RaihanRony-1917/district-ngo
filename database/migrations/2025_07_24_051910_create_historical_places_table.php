<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historical_places', function (Blueprint $table) {
            $table->id();
            $table->string('name', '255');
            $table->foreignId('lang_id')->default(1)->constrained('languages')->onDelete('cascade');
            $table->text('short_text')->nullable();
            $table->string('location', '255')->nullable();
            $table->integer('serial')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->string('image', '255')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historical_places');
    }
};
