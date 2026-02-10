<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetardNotification extends Model
{
    protected $fillable = [
        'lot_copie_id',
        'type',
        'sent_at',
    ];
}
