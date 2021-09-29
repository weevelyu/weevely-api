<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'calendar_id',
        'title',
        'content',
        'category',
        'target',
        'duration',
        'system'
    ];

    protected $casts = [
        'calendar_id' => 'integer',
        'title' => 'string',
        'content' => 'string',
        'category' => 'string',
        'target' => 'datetime',
        'duration' => 'integer',
        'system' => 'boolean'
    ];

    public function calendar()
    {
        return $this->hasOne(Calendar::class);
    }
}
