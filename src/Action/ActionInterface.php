<?php

namespace Coff\TestAssignment\Action;

use Coff\TestAssignment\Booster\BoosterInterface;

interface ActionInterface
{
    public function getTimeStarts() : \DateTime;

    public function getPointsEarned() : int;

    public function hasBoosterAssigned() : bool;

    public function assignBooster(BoosterInterface $booster) : self;
}