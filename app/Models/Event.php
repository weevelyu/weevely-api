<?php

namespace App\Models;

class Event extends \Illuminate\Database\Eloquent\Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'calendar_id',
        'title',
        'content',
        'category',
        'target',
        'system'
    ];

    protected $casts = [
        'calendar_id' => 'integer',
        'title' => 'string',
        'content' => 'string',
        'category' => 'string',
        'target' => 'datetime',
        'system' => 'boolean'
    ];

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
