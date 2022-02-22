<?php

namespace Coff\TestAssignment\Action;

interface DurationActionInterface extends ActionInterface
{
    public function setTimeEnds(\DateTime $timeEnds) : self;

    public function getTimeEnds() : \DateTime;
}