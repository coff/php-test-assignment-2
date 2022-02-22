<?php

namespace Coff\TestAssignment\Action;

class RideshareAction extends Action
{
    public function __construct(\DateTime $timeStarts)
    {
        parent::__construct($timeStarts);

        $this->pointsPerAction = 1;
    }

    public function getName(): string
    {
        return "Rideshare on " . $this->getTimeStarts()->format('M, d H:i');
    }
}