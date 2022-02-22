<?php

class RentActionTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        $this->object = new \Coff\TestAssignment\Action\RentAction(new DateTime('2022-01-01 00:00:00'));
    }

    public function testGetPointsEarned_whenCurrentBeforeEnds()
    {
        $this->object->setTimeCurrent(new DateTime('2022-01-11 00:00:00'));
        $this->object->setTimeEnds(new DateTime('2022-01-20 00:00:00'));

        $this->assertEquals( 2 * 10, $this->object->getPointsEarned());
    }

    public function testGetPointsEarned_whenCurrentAfterEndsShouldReturnZero()
    {
        $this->object->setTimeCurrent(new DateTime('2021-12-21 00:00:00'));
        $this->object->setTimeEnds(new DateTime('2022-01-11 00:00:00'));

        $this->assertEquals( 0, $this->object->getPointsEarned());
    }

    public function testGetPointsEarned_whenCurrentBeforeStarts()
    {
        $this->object->setTimeCurrent(new DateTime('2022-01-21 00:00:00'));
        $this->object->setTimeEnds(new DateTime('2022-01-11 00:00:00'));

        $this->assertEquals( 2 * 10, $this->object->getPointsEarned());
    }
}