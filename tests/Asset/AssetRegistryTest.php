<?php

class AssetRegistryTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        $this->object = new \Coff\TestAssignment\Asset\AssetRegistry();
    }

    public function testGetAssets_willHaveBooster()
    {
        $actionStub = $this
            ->createStub(\Coff\TestAssignment\Action\DeliveryAction::class);
        $this->object->setBoosterTemplate(get_class($actionStub), $deliveriesTpl = new \Coff\TestAssignment\Booster\DeliveriesBooster());
        $deliveriesTpl->setTimeCurrent(new DateTime('2022-01-01 00:00:00'));
        $time = new DateTime('2021-01-01 00:00:00');

        for ($i=1; $i<=5; $i++) {
            $stub = clone $actionStub;
            $stub->method('getTimeStarts')
                ->willReturn(clone $time);
            $stub->method('assignBooster')
                ->willReturnSelf();

            // adding minutes each time
            $time->add(new DateInterval('PT29M59S'));

            $this->object->add($stub);
        }

        $assets = $this->object->getAssets();

        $this->assertCount(6, $assets);

        $expectedBooster = array_pop($assets);

        $this->assertInstanceOf(\Coff\TestAssignment\Booster\DeliveriesBooster::class, $expectedBooster);
    }

    public function testGetAssets_willNotHaveBooster()
    {
        $actionStub = $this
            ->createStub(\Coff\TestAssignment\Action\DeliveryAction::class);
        $this->object->setBoosterTemplate(get_class($actionStub), $deliveriesTpl = new \Coff\TestAssignment\Booster\DeliveriesBooster());
        $deliveriesTpl->setTimeCurrent(new DateTime('2022-01-01 00:00:00'));
        $time = new DateTime('2021-01-01 00:00:00');

        for ($i=1; $i<=5; $i++) {
            $stub = clone $actionStub;
            $stub->method('getTimeStarts')
                ->willReturn(clone $time);
            $stub->method('assignBooster')
                ->willReturnSelf();

            // adding minutes each time
            $time->add(new DateInterval('PT30M'));

            $this->object->add($stub);
        }

        $assets = $this->object->getAssets();

        $this->assertCount(5, $assets);

    }
}