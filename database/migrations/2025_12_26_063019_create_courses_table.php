<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('url')->nullable();
            $table->longText('content')->nullable();

            // stores: affiliation/filename.ext
            $table->string('image')->nullable();

            // active / block (same as old PHP)
            $table->enum('status', ['active', 'block'])->default('active');

            // replaces added_date
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
