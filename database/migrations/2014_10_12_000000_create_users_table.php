<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            // Basic Info
            $table->string('email', 200)->unique();
            $table->string('name', 50);
            $table->string('password', 255); // ✅ bcrypt needs 255
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 60)->nullable();
            $table->string('zipcode', 60)->nullable();
            $table->string('state', 50)->nullable();
            $table->integer('country')->default(0);

            // Role & Status
            $table->enum('user_role', ['user', 'admin', 'sub_admin'])->default('user');
            $table->string('confirm_code', 30)->nullable();
            $table->enum('account_confirm', ['unconfirm', 'confirm'])->default('confirm');
            $table->enum('account_status', ['active', 'block'])->default('active');

            // Laravel timestamps
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};