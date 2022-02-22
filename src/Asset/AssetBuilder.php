<?php

namespace Coff\TestAssignment\Asset;

use Coff\TestAssignment\Action\ActionInterface;

class AssetBuilder
{
    protected \DateTime $timeCurrent;

    public function setTimeCurrent(\DateTime $timeCurrent) : self
    {
        $this->timeCurrent = $timeCurrent;

        return $this;
    }

    public function build(string $className, \DateTime $dateTime) : ActionInterface
    {
        /** @var ActionInterface $asset */
        $asset = new $className ($dateTime);
        $asset->setTimeCurrent($this->timeCurrent);
        return $asset;
    }
}