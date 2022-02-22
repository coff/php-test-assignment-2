<?php

namespace Coff\TestAssignment\Booster;

use Coff\TestAssignment\Action\Action;
use Coff\TestAssignment\Action\ActionInterface;
use Coff\TestAssignment\Asset\ExpirableAsset;
use Coff\TestAssignment\Exception\ExclusivityActionException;

abstract class Booster extends ExpirableAsset implements BoosterInterface
{
    /** @var array <int,Action> */
    protected array $actions = [];
    protected int $maxActions;
    protected bool $isCommitted = false;
    protected bool $isZombie = false;
    protected $pointsPerBooster = 0;

    /**
     * @param ActionInterface $action
     * @return void
     * @throws \Exception
     */
    protected function addAction(ActionInterface $action) :void
    {
        if ($this->hasReachedActionsLimit()) {
            throw new \Exception('Action limit reached!');
        }

        $this->actions[] = $action;
    }

    protected function setActionsToExclusive()
    {
        if (!$this->hasReachedActionsLimit()) {
            throw new \Exception('Not enough actions');
        }

        /** @var Action $action */
        try {
            foreach ($this->actions as $action) {
                $action->assignBooster($this);
            }
        } catch (ExclusivityActionException $exception) {
            // not enough exclusive actions to commit
            $this->isZombie = true;

            throw $exception;
        }
    }


    public function getPointsEarned(): int
    {
        return $this->isCommitted ? $this->pointsPerBooster : 0;
    }

    public function hasReachedActionsLimit(): bool
    {
        return count($this->actions) >= $this->maxActions;
    }

    public function isZombie() : bool
    {
        return $this->isZombie;
    }

    public function isCommitted() : bool
    {
        return $this->isCommitted;
    }

}