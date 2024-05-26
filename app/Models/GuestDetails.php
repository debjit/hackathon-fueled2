<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestDetails extends Model
{
    use HasFactory;

    protected $fillabele = [
        'phone',
        'email',
        'room_number',
        'occupency',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
