<?php

namespace App\Services\Dashboards\Transformers;

use Carbon\Carbon;

class Event
{
    public static function transformAll($events)
    {
        return collect($events)->map(function ($event) {
            return self::transform($event);
        });
    }

    public static function transform(\Google_Service_Calendar_Event $event = null)
    {
        return [
            'summary'     => $event->getSummary(),
            'description' => $event->getDescription(),
            'times'       => self::getTimeRange($event),
            'links'       => [
                'hangout'  => $event->hangoutLink,
                'calendar' => $event->htmlLink,
            ],
        ];
    }

    private static function getTimeRange(\Google_Service_Calendar_Event $event)
    {
        if (is_null($event->getStart()->dateTime)) {
            return Carbon::parse($event->start->getDate())->format('F jS') . ' All Day';
        }

        if (is_null($event->getRecurringEventId())) {
            return Carbon::parse($event->start->getDateTime())->format('F jS: g:ia')
                   . ' - ' .
                   Carbon::parse($event->end->getDateTime())->format('g:ia');
        }

        $event = is_null($event->getRecurrence()) ? $event : $event->getRecurrence();

        return Carbon::parse($event->start->getDateTime())->format('F jS - g:ia')
               . ' - ' .
               Carbon::parse($event->end->getDateTime())->format('F jS - g:ia');
    }
}
