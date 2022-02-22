<?php

namespace Coff\TestAssignment\Action;

class DeliveryAction extends Action
{
    public function __construct(\DateTime $timeStarts)
    {
        parent::__construct($timeStarts);

        $this->pointsPerAction = 1;
    }

    public function getName(): string
    {
        return "Delivery on " . $this->getTimeStarts()->format('M, d H:i');
    }
}