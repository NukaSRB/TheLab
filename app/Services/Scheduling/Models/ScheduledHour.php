<?php

namespace App\Services\Scheduling\Models;

use App\Models\BaseModel;
use App\Models\User;
use App\Services\Clients\Models\Client;

class ScheduledHour extends BaseModel
{
    protected $table = 'scheduled_hours';

    protected $fillable = [
        'user_id',
        'client_id',
        'date',
        'hours',
        'note',
    ];

    protected $dates = [
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
