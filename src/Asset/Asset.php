<?php

namespace Coff\TestAssignment\Asset;

abstract class Asset implements AssetInterface
{
    protected $timeCreated;
    protected $pointsPerAction;
    protected \DateTime $timeCurrent;

    public function setTimeCurrent(\DateTime $timeCurrent): self
    {
        $this->timeCurrent = $timeCurrent;

        return $this;
    }

    public function getTimeCreated(): \DateTime
    {
        return $this->timeCreated;
    }

    public function isExpired(): bool
    {
        return false;
    }
}