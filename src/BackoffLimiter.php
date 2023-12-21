<?php

namespace Beholdr\BackoffLimiter;

use Illuminate\Cache\RateLimiter;
use Illuminate\Contracts\Cache\Repository;

class BackoffLimiter extends RateLimiter
{
    protected int $backoff;

    protected int $exponent;

    public function __construct(Repository $cache, int $backoff = 3600, int $exponent = 2)
    {
        parent::__construct($cache);

        $this->backoff = $backoff;
        $this->exponent = $exponent;
    }

    /**
     * Increment the counter for a given key for a given decay time.
     *
     * @param  string  $key
     * @param  int  $decaySeconds
     * @return int
     */
    public function hit($key, $decaySeconds = 60)
    {
        return parent::hit($key, $decaySeconds * $this->getMultiplier($key));
    }

    protected function getMultiplier(string $key): int
    {
        $backoffKey = $key.':backoff';

        parent::hit($backoffKey, $this->backoff);

        $attempts = $this->attempts($backoffKey);

        return pow($attempts, $this->exponent);
    }
}
