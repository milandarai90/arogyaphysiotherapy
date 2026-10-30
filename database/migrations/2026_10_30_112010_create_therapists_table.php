
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);
            $table->string('designation', 150)->nullable();
            $table->string('qualification')->nullable();
            $table->string('specialization')->nullable();
            $table->unsignedSmallInteger('experience_years')->default(0);

            $table->text('bio')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();

            $table->string('photo')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('therapists');
    }
};
