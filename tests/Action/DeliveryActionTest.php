<?php

class DeliveryActionTest extends \PHPUnit\Framework\TestCase
{
    protected $object, $anyPointInTime;

    public function setUp(): void
    {
        $this->object = new \Coff\TestAssignment\Action\DeliveryAction(new DateTime('2022-01-01 10:00:00'));
        $this->object->setTimeCurrent($this->anyPointInTime = new DateTime('2022-01-10 10:00:00'));
    }

    public function testGetPointsEarned_equals1() {
        $this->assertEquals(1, $this->object->getPointsEarned());
    }

    public function testGetPointsEarned_beforeItActuallyHappens() {
        $this->anyPointInTime->setDate(2021,12,31);
        $this->assertEquals(0, $this->object->getPointsEarned());
    }

    public function testAssignBoooster_hasBoosterAssigned() {
        $this->assertFalse($this->object->hasBoosterAssigned());
        $this->object->assignBooster(new \Coff\TestAssignment\Booster\DeliveriesBooster());
        $this->assertTrue($this->object->hasBoosterAssigned());
    }

    public function testAssignBoooster_OnlyPossibleOnce() {
        $this->object->assignBooster(new \Coff\TestAssignment\Booster\DeliveriesBooster());

        $this->expectException(\Coff\TestAssignment\Exception\ExclusivityActionException::class);
        $this->expectExceptionMessage('Already assigned!');
        $this->object->assignBooster(new \Coff\TestAssignment\Booster\DeliveriesBooster());
    }
}