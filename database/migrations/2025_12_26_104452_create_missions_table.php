<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->string('image')->nullable();   // affiliation_*.jpg
            $table->enum('status',['active','block'])->default('active');
            $table->timestamps(); // replaces added_date
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
