<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_visits', function (Blueprint $table) {
            $table->id();

            // URL path visited, without query parameters.
            $table->string('page_path', 500)->index();

            // SHA-256 hash of the browser's visitor cookie.
            $table->string('visitor_id', 64)->index();

            $table->timestamp('visited_at')->index();

            $table->timestamps();

            $table->index(['visited_at', 'visitor_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_visits');
    }
};