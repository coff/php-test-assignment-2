<?php

namespace Coff\TestAssignment\Booster;

use Coff\TestAssignment\Action\ActionInterface;
use Coff\TestAssignment\Action\DeliveryAction;
use Coff\TestAssignment\Exception\ExclusivityActionException;

abstract class DateIntervalBooster extends Booster
{
    /** @var \DateInterval */
    protected $dateInterval;
    protected ?\DateTime $firstActionTime = null;
    protected ?\DateTime $lastActionTime = null;

    public function addActionIfQualifies(ActionInterface $action)
    {
        // finding first and last action time for this booster
        if ($this->firstActionTime === null || $action->getTimeStarts() < $this->firstActionTime) {
            $this->firstActionTime = clone $action->getTimeStarts();
        }

        if ($this->lastActionTime === null || $action->getTimeStarts() > $this->lastActionTime) {
            $this->lastActionTime = clone $action->getTimeStarts();
        }

        // first, action is added to several open boosters
        // when commited such booster gets exclusive ownership of the action so do not worry ;)
        $this->addAction($action);

        if (!$this->hasReachedActionsLimit()) {
            return;
        }

        if ((clone $this->lastActionTime)->sub($this->dateInterval) < $this->firstActionTime) {

            // try to enforce actions exclusivity
            try {
                $this->setActionsToExclusive();
                $this->isCommitted = true;
                $this->timeCreated = clone $this->lastActionTime;
                return;
            } catch (ExclusivityActionException $exception) {
                $this->isZombie = true;
                // either of actions already consumed by another booster, sorry!
            }

        } else {
            $this->isZombie = true;
        }
    }
}