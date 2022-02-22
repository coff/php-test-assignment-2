<?php

namespace Coff\TestAssignment\Action;

class RentAction extends Action implements DurationActionInterface
{
    protected ?\DateTime $timeEnds = null;

    public function __construct(\DateTime $timeStarts, \DateTime $timeEnds = null)
    {
        parent::__construct($timeStarts);

        $this->timeEnds = $timeEnds;
        $this->pointsPerAction = 2;
    }

    public function setTimeEnds(\DateTime $timeEnds): self
    {
        $this->timeEnds = $timeEnds;

        return $this;
    }

    public function getTimeEnds(): \DateTime
    {
        return $this->timeEnds;
    }

    public function getPointsEarned(): int
    {
        // not even started yet?
        if ($this->timeCurrent < $this->timeStarts) {
            return 0;
        }

        // consider timeCurrent if before timeEnds
        $time = (isset($this->timeEnds) && $this->timeEnds < $this->timeCurrent) ? $this->timeEnds : $this->timeCurrent;

        $durationDays = $time->diff($this->timeStarts)->days;

        return $durationDays * $this->pointsPerAction;
    }

    public function getName(): string
    {
        $time = (isset($this->timeEnds) && $this->timeEnds < $this->timeCurrent) ? $this->timeEnds : $this->timeCurrent;
        return "Rent on " . $this->getTimeStarts()->format('F j, Y') . ' to ' . $time->format('F j, Y');
    }
}