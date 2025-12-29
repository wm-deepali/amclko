<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skill_devs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('image')->nullable(); // stores affiliation/filename
            $table->enum('status', ['active', 'block'])->default('active');
            $table->timestamps(); // replaces added_date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_devs');
    }
};
