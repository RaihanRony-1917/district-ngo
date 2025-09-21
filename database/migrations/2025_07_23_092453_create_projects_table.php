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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_id')->constrained('project_categories')->onDelete('cascade');
            $table->tinyInteger('is_featured')->default(0);
            $table->text('short_text')->nullable();
            $table->text('content')->nullable();
            $table->text('tags')->nullable();
            $table->integer('serial')->default(1);
            $table->tinyInteger('state')->default(2);
            $table->tinyInteger('status')->default(1);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
