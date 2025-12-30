<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {

            $table->id();

            // Basic info
            $table->string('title');
            $table->string('slug')->unique();

            // Images
            $table->string('thumbnail')->nullable(); // listing card
            $table->string('banner')->nullable();    // detail page top image

            // Content
            $table->longText('content'); // HTML from editor

            // Status
            $table->enum('status', ['active', 'block'])
                  ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
