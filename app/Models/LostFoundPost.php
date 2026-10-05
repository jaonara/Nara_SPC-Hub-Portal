<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LostFoundPost extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'item_name',
        'description',
        'location',
        'event_date',
        'image',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(PostComment::class, 'commentable');
    }

    public function privateMessages(): MorphMany
    {
        return $this->morphMany(PrivateMessage::class, 'messageable');
    }
}
