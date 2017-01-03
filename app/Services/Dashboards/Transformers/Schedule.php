<?php

namespace App\Services\Dashboards\Transformers;

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
                'label' => $resource->client->label,
                'name'  => $resource->client->name,
                'color' => $resource->client->color,
            ],
            'time'       => $resource->time,
            'hours'      => $resource->hours,
            'percentage' => percent($resource->time, $resource->hours),
        ];
    }
}
