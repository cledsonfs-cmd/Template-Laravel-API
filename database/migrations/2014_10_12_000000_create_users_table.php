<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    DB::statement('CREATE SCHEMA IF NOT EXISTS template_laravel');
    Schema::create('template_laravel.users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('email')->unique();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->string('provedor')->default('');
      $table->string('imageUrl')->default('');
      $table->integer('id_role')->default(0);
      $table->integer('id_status')->default(0);
      $table->rememberToken();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('template_laravel.users');
  }
};
