<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'booking_reference',
        'patient_name',
        'phone',
        'age',
        'service_id',
        'appointment_date',
        'appointment_time',
        'symptoms',
        'patient_message',
        'status',
        'rescheduled_date',
        'rescheduled_time',
        'admin_note',
    ];

    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'rescheduled_date' => 'date',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
