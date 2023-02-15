<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventNumbers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'random_number',
        'info_text',
        'winning_amount',
    ];
}
