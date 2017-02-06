<?php

namespace App\Models;

use App\Services\Clients\Models\Project;
use App\Services\Scheduling\Models\ScheduledHour;
use Carbon\Carbon;
use JumpGate\Users\Models\User as BaseUser;
use JumpGate\Users\Traits\HasSocials;

class User extends BaseUser
{
    use HasSocials;

    public function getProjectsForSchedule()
    {
        $projectIds = $this->scheduledHours()
                           ->where('date', '>=', Carbon::now()->startOfWeek()->format('Y-m-d'))
                           ->where('date', '<=', Carbon::now()->addWeeks(3)->endOfWeek()->format('Y-m-d'))
                           ->orderBy('project_id')
                           ->groupBy('project_id')
                           ->select('project_id')
                           ->get(['project_id'])
                           ->flatMap(function ($project) {
                               return [$project->project_id];
                           })
                           ->toArray();

        return Project::with('client')
                      ->whereIn('id', $projectIds)
                      ->get();
    }

    public function scheduledHours()
    {
        return $this->hasMany(ScheduledHour::class, 'user_id');
    }
}
