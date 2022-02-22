<?php

namespace Coff\TestAssignment\Action;

use Coff\TestAssignment\Asset\Asset;
use Coff\TestAssignment\Booster\BoosterInterface;
use Coff\TestAssignment\Exception\ExclusivityActionException;

abstract class Action extends Asset implements ActionInterface
{
    protected \DateTime $timeStarts;

    protected $booster;

    public function __construct(\DateTime $timeStarts)
    {
        $this->timeStarts = $timeStarts;
    }

    public function getTimeStarts(): \DateTime
    {
        return $this->timeStarts;
    }

    public function getPointsEarned(): int
    {
        if ($this->timeCurrent < $this->timeStarts) {
            return 0;
        }

        // equals pointsPerAction by default
        return $this->pointsPerAction;
    }

    public function hasBoosterAssigned(): bool
    {
        return $this->booster instanceof BoosterInterface;
    }

    public function assignBooster(BoosterInterface $booster): self
    {
        if ($this->booster instanceof BoosterInterface) {
            throw new ExclusivityActionException('Already assigned!');
        }

        $this->booster = $booster;

        return $this;
    }

    public function isExpired(): bool
    {
        // these points never expire
        return false;
    }
}