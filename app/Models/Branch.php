<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'phone',
        'whatsapp',
        'email',
        'address',
        'city',
        'district',
        'province',
        'google_maps_url',
        'google_maps_embed_url',
        'opening_time',
        'closing_time',
        'working_days',
        'image',
        'is_main',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_main' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'working_days' => 'array',
    ];

    public function appointments(): HasMany
{
    return $this->hasMany(Appointment::class);
}
}