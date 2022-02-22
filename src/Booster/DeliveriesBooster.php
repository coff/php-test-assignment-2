<?php

namespace Coff\TestAssignment\Booster;

use Coff\TestAssignment\Action\ActionInterface;
use Coff\TestAssignment\Action\DeliveryAction;
use Coff\TestAssignment\Exception\ExclusivityActionException;

class DeliveriesBooster extends DateIntervalBooster
{
    public function __construct()
    {
        $this->pointsPerBooster = 5;
        $this->maxActions = 5;
        $this->dateInterval =  new \DateInterval('PT2H');
        $this->expireInterval = new \DateInterval('P1M');
    }

    public function getName(): string
    {
        return 'Deliveries booster ' . $this->maxActions . ' in ' . $this->dateInterval->format('%h hours');
    }
}