
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();

            $table->string('booking_reference')->unique();

            $table->string('patient_name');
            $table->string('phone', 20);
            $table->unsignedTinyInteger('age');

            $table->foreignId('service_id')
                ->constrained('services')
                ->restrictOnDelete();

            $table->date('appointment_date');
            $table->time('appointment_time');

            $table->text('symptoms')->nullable();
            $table->text('patient_message')->nullable();

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'rescheduled',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->date('rescheduled_date')->nullable();
            $table->time('rescheduled_time')->nullable();

            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
