<?php

namespace Coff\TestAssignment\Asset;

interface AssetInterface
{
    public function getName() : string;

    public function setTimeCurrent(\DateTime $timeCurrent) : self;

    public function getPointsEarned() : int;

    public function isExpired() : bool;
}