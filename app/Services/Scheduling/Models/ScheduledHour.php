<?php

namespace App\Services\Scheduling\Models;

use App\Models\BaseModel;
use App\Models\User;
use App\Services\Clients\Models\Project;
use Carbon\Carbon;

class ScheduledHour extends BaseModel
{
    protected $table = 'scheduled_hours';

    protected $fillable = [
        'user_id',
        'project_id',
        'date',
        'hours',
        'repeat',
        'note',
    ];

    protected $dates = [
        'date',
    ];

    /**
     * Get all scheduled hours for a user on a given day.
     *
     * @param \Carbon\Carbon $date
     * @param int            $userId
     *
     * @return mixed
     */
    public static function getHoursForDate(Carbon $date, $userId)
    {
        return static::with('project.client')
                     ->where('date', $date->format('Y-m-d'))
                     ->where('user_id', $userId)
                     ->orderBy('project_id')
                     ->get();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
