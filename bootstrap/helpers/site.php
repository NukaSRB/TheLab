<?php

function displayFlag($flag, $positiveMessage = 'Yes', $negativeMessage = 'No')
{
    if ($flag) {
        return $positiveMessage;
    }

    return $negativeMessage;
}

function displayIcon($flag, $colorize = true, $positiveIcon = 'check-circle', $negativeIcon = 'times-circle')
{
    if ($flag) {
        $color = $colorize ? 'text-green' : '';

        return '<i class="fa fa-fw fa-' . $positiveIcon . ' ' . $color . '"></i>';
    }

    $color = $colorize ? 'text-red' : '';

    return '<i class="fa fa-fw fa-' . $negativeIcon . ' ' . $color . '"></i>';
}
