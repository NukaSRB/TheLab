<?php

namespace App\Services\Scheduling\Transformers;

use App\Transformers\Transformer;

class Schedule extends Transformer
{
    /**
     * @param \App\Services\Scheduling\Models\ScheduledHour $resource
     *
     * @return array
     */
    public static function transform($resource)
    {
        return [
            'client'     => [
                'abbreviation' => $resource->project->client->abbreviation,
                'label'        => $resource->project->client->label,
                'name'         => $resource->project->client->name,
            ],
            'project'    => [
                'label' => $resource->project->label,
                'name'  => $resource->project->name,
                'color' => $resource->project->color,
            ],
            'time'       => $resource->time,
            'hours'      => $resource->hours,
            'percentage' => percent($resource->time, $resource->hours),
        ];
    }
}
