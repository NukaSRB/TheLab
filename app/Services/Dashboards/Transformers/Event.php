<?php

namespace App\Services\Dashboards\Transformers;

use App\Transformers\Transformer;
use Carbon\Carbon;

class Event extends Transformer
{
    /**
     * @param \Google_Service_Calendar_Event $resource
     *
     * @return array
     */
    public static function transform($resource)
    {
        return [
            'summary'     => $resource->getSummary(),
            'description' => $resource->getDescription(),
            'times'       => self::getTimeRange($resource),
            'links'       => [
                'hangout'  => $resource->hangoutLink,
                'calendar' => $resource->htmlLink,
            ],
        ];
    }

    /**
     * @param \Google_Service_Calendar_Event $resource
     *
     * @return string
     */
    private static function getTimeRange($resource)
    {
        if (is_null($resource->getStart()->dateTime)) {
            return Carbon::parse($resource->start->getDate())->format('F jS') . ' All Day';
        }

        if (is_null($resource->getRecurringEventId())) {
            return Carbon::parse($resource->start->getDateTime())->format('F jS: g:ia')
                   . ' - ' .
                   Carbon::parse($resource->end->getDateTime())->format('g:ia');
        }

        $resource = is_null($resource->getRecurrence()) ? $resource : $resource->getRecurrence();

        return Carbon::parse($resource->start->getDateTime())->format('F jS - g:ia')
               . ' - ' .
               Carbon::parse($resource->end->getDateTime())->format('F jS - g:ia');
    }
}
