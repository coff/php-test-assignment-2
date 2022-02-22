<?php

namespace Coff\TestAssignment\Asset;

use Coff\TestAssignment\Action\ActionInterface;
use Coff\TestAssignment\Booster\BoosterInterface;

class AssetRegistry
{
    protected $assets = [];
    protected $boosterTemplates = [];
    protected $openedBoosters = [];

    public function setBoosterTemplate(string $className, BoosterInterface $booster) : self
    {
        $this->boosterTemplates[$className] = $booster;

        return $this;
    }

    protected function makeNewBooster(string $className) : ?BoosterInterface
    {
        return isset($this->boosterTemplates[$className]) ? clone $this->boosterTemplates[$className] : null;
    }



    public function add(ActionInterface $action) : self
    {
        $className = get_class($action);
        $this->assets[] = $action;

        // new action may be a part of a new booster
        $booster = $this->makeNewBooster($className);

        // no booster defined for this type of action
        if ($booster === null) {
            return $this;
        }

        $this->openedBoosters[$className][] = $booster;

        /**
         * @var int $key
         * @var BoosterInterface $booster
         */
        foreach ($this->openedBoosters[$className] as $key => $booster) {

            // adding compatible actions for each of the open boosters
            $booster->addActionIfQualifies($action);

            if ($booster->isCommitted()) {
                $this->assets[] = $booster;
                unset($this->openedBoosters[$className][$key]);
            }

            if ($booster->hasReachedActionsLimit() || $booster->isZombie()) {
                unset($this->openedBoosters[$className][$key]);
            }
        }

        return $this;
    }

    public function getAssets()
    {
        return $this->assets;
    }

    public function getPointBalance() {

        $points = 0;

        /** @var AssetInterface $asset */
        foreach ($this->assets as $asset) {

            if (!$asset->isExpired()) {
                $points+=$asset->getPointsEarned();
            }
        }

        return $points;
    }
}