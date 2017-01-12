<?php

namespace App\Services\Timing\Commands;

use App\Apis\Toggl\Client;
use App\Services\Timing\Transformers\Timer as TimerTransformer;

class Timer
{
    /**
     * @var \App\Apis\Toggl\Client
     */
    private $toggl;

    /**
     * @var null
     */
    private $timer;

    private $togglToken;

    /**
     * @var bool
     */
    private $replaceCache;

    /**
     * Timer constructor.
     *
     * @param \App\Apis\Toggl\Client $toggl
     * @param null                   $timer
     * @param bool                   $replaceCache
     */
    public function __construct(Client $toggl, $timer = null, $replaceCache = false)
    {
        $this->toggl        = $toggl;
        $this->timer        = $timer;
        $this->replaceCache = $replaceCache;
    }

    public function __invoke()
    {
        if (! $this->canUseToggl()) {
            return null;
        }

        // See if the results are cached.
        $cacheKey = 'toggl:timer:' . $this->togglToken;

        if (cache()->has($cacheKey) && ! $this->replaceCache) {
            return cache($cacheKey);
        }

        if (is_null($this->timer)) {
            $this->getTimer($this->togglToken);
        }

        if (! is_null($this->timer)) {
            // Convert the timer to something usable.
            $this->timer = TimerTransformer::transform($this->timer);
        }

        cache()->put($cacheKey, $this->timer, 1);

        return $this->timer;
    }

    private function canUseToggl()
    {
        // No timer is they haven't linked toggl.
        if (! auth()->user()->hasProvider('toggl')) {
            return false;
        }

        $this->togglToken = auth()->user()->getProvider('toggl')->token;

        // No timer if they haven't added their token.
        if (is_null($this->togglToken) || $this->togglToken === '') {
            return false;
        }

        return true;
    }

    private function getTimer()
    {
        // Get the current timer from Toggl.
        $timer = $this->toggl
            ->setApiKey($this->togglToken)
            ->handle('GetCurrentTimeEntry');

        // If no active timer, set null.
        if (array_key_exists('data', $timer)) {
            return $this->timer = null;
        }

        $this->timer = $timer;
    }
}
