<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gallery_category_program', function (Blueprint $table) {
            $table->id();

            $table->foreignId('gallery_category_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('program_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unique(['gallery_category_id', 'program_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_category_program');
    }
};
