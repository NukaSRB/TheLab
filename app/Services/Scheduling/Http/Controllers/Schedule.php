<?php

namespace App\Services\Scheduling\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\User;
use App\Services\Scheduling\Models\Month;
use App\Services\Scheduling\Models\ScheduledHour;
use Carbon\Carbon;

class Schedule extends BaseController
{
    /**
     * @var \App\Models\User
     */
    private $users;

    /**
     * @var \App\Services\Scheduling\Models\ScheduledHour
     */
    private $scheduledHours;

    /**
     * Schedule constructor.
     *
     * @param \App\Models\User                              $users
     * @param \App\Services\Scheduling\Models\ScheduledHour $scheduledHours
     */
    public function __construct(User $users, ScheduledHour $scheduledHours)
    {
        $this->users          = $users;
        $this->scheduledHours = $scheduledHours;
    }

    public function index()
    {
        $users = $this->users->orderByNameAsc()->get()->filter(function (User $user) {
            return $user->hasRole('employee');
        });

        $availableDays = new Month();

        foreach ($users as $user) {
            $user->projects = $user->getProjectsForSchedule()->keyBy('id');
            $user->schedule = new Month($user);
        }

        $this->setJavascriptData(compact(
            'users',
            'scheduledHours',
            'availableDays'
        ));

        return $this->view();
    }

}
