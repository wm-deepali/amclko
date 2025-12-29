<?php

// database/migrations/xxxx_xx_xx_create_videos_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('url');
            $table->enum('status', ['active','block'])->default('active');
            $table->timestamps(); // replaces added_date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};

