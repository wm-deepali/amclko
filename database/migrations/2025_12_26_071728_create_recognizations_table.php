<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('recognizations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'block'])->default('active');
            $table->timestamps(); // replaces added_date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recognizations');
    }
};

