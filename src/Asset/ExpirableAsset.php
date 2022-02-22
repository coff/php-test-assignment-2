<?php

namespace Coff\TestAssignment\Asset;

abstract class ExpirableAsset extends Asset
{
    /** @var \DateInterval */
    protected \DateInterval $expireInterval;

    public function isExpired(): bool
    {
        return (clone $this->timeCurrent)->sub($this->expireInterval) >= $this->timeCreated;
    }
}