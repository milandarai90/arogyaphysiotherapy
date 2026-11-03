<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('phone', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();

            $table->string('email')->nullable();

            $table->text('address');
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('province')->nullable();

            $table->text('google_maps_url')->nullable();
            $table->text('google_maps_embed_url')->nullable();

            $table->string('opening_time')->nullable();
            $table->string('closing_time')->nullable();
            $table->text('working_days')->nullable();

            $table->string('image')->nullable();

            $table->boolean('is_main')->default(false);
            $table->boolean('is_active')->default(true);

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};