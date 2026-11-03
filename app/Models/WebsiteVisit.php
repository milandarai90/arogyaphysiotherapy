<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteVisit extends Model
{
    protected $fillable = [
        'page_path',
        'visitor_id',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];
}