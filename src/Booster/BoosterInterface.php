<?php

namespace Coff\TestAssignment\Booster;

use Coff\TestAssignment\Action\ActionInterface;

interface BoosterInterface
{
    public function addActionIfQualifies(ActionInterface $action);

    public function getPointsEarned() : int;

    public function hasReachedActionsLimit() : bool;

    public function isCommitted() : bool;

    public function isZombie() : bool;
}