<?php

if (! function_exists('setTime')) {
    function setTime($time)
    {
        if (auth()->check()) {
            $timezone = is_null(auth()->user()->timezone) ? config('app.default_user_timezone') : auth()->user()->timezone;

            return \Camroncade\Timezone\Facades\Timezone::convertToUTC($time, $timezone);
        }

        return $time;
    }
}

if (! function_exists('getTime')) {
    function getTime($time)
    {
        $timeZone = null;

        if (auth()->check()) {
            $timeZone = auth()->user()->timezone;
            $time     = \Camroncade\Timezone\Facades\Timezone::convertFromUTC($time, $timeZone);
        }

        return \Carbon\Carbon::parse($time, $timeZone);
    }
}

if (! function_exists('carbonParse')) {
    function carbonParse($date)
    {
        if (auth()->check()) {
            return \Carbon\Carbon::parse($date)->setTimezone(auth()->user()->timezone);
        }

        return \Carbon\Carbon::parse($date);
    }
}

if (! function_exists('convertToSeconds')) {
    /**
     * Convert a time string (HH:MM:SS) to seconds.
     *
     * @param $time
     *
     * @return mixed
     */
    function convertToSeconds($time)
    {
        $timeIntervals = explode(':', $time);

        // We have hours.  Convert it all to seconds.
        if (isset($timeIntervals[2])) {
            $seconds = $timeIntervals[2];
            $minutes = $timeIntervals[1] * 60;
            $hours   = $timeIntervals[0] * 60 * 60;

            return $hours + $minutes + $seconds;
        }

        // Only minutes.  Convert all to seconds.
        if (isset($timeIntervals[1])) {
            $seconds = $timeIntervals[1];
            $minutes = $timeIntervals[0] * 60;

            return $minutes + $seconds;
        }

        // We only have seconds.  Return it.
        return $timeIntervals[0];
    }
}

if (! function_exists('convertFromSeconds')) {
    /**
     * Take a number of seconds and return it as a readable amount of time.
     *
     * @param $time
     *
     * @return string
     */
    function convertFromSeconds($time)
    {
        $units = [
            'week'   => 7 * 24 * 3600,
            'day'    => 24 * 3600,
            'hour'   => 3600,
            'minute' => 60,
            'second' => 1,
        ];

        // specifically handle zero
        if ($time == 0) {
            return '0 seconds';
        }

        $s = '';

        foreach ($units as $name => $divisor) {
            if ($quot = intval($time / $divisor)) {
                $num = sprintf('%02s', $quot);
                $s .= "$num" . ':';
                $time -= $quot * $divisor;
            }
        }

        return substr($s, 0, -1);
    }
}

function convertMicroSeconds($duration)
{
    list($hours, $minutes, $seconds) = convertMicroSecondsArray($duration);

    return ($hours == 0 ? "00" : $hours) . ":" . ($minutes == 0 ? "00" : ($minutes < 10 ? "0" . $minutes : $minutes)) . ":" . ($seconds == 0 ? "00" : ($seconds < 10 ? "0" . $seconds : $seconds));
}

function convertMicroSecondsArray($duration)
{
    $hours = (int)($duration / 60 / 60);

    $minutes = (int)($duration / 60) - $hours * 60;

    $seconds = (int)$duration - $hours * 60 * 60 - $minutes * 60;

    return compact('hours', 'minutes', 'seconds');
}

function decimalHours(array $times)
{
    return round($times['hours'] + ($times['minutes']/60) + ($times['seconds']/3600), 2);
}

