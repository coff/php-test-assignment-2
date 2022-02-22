<?php

class DeliveriesBoosterTest extends \PHPUnit\Framework\TestCase
{
    protected $object;
    protected $timeCreatedRefl;

    public function setUp(): void
    {
        $this->object = new \Coff\TestAssignment\Booster\DeliveriesBooster();

        $reflection = new ReflectionClass($this->object);
        $this->timeCreatedRefl = $reflection->getProperty('timeCreated');
        $this->timeCreatedRefl->setAccessible(true);

        //$this->timeCreatedRefl->setValue($this->object, new DateTime('2021-01-01 00:00:00'));
    }

    public function datesProvider()
    {
        return [
            ['2021-01-01 00:00:00', '2021-02-01 00:00:00', true],
            ['2021-01-01 00:00:00', '2021-01-01 23:59:59', false],
            ['2021-01-01 00:00:00', '2021-01-31 23:59:59', false],
            ['2021-01-01 00:00:00', '2021-03-01 00:00:00', true]
        ];
    }

    /** @dataProvider datesProvider */
    public function testIsExpired($dateCreated, $controlDate, $expected)
    {
        $this->object->setTimeCurrent(new DateTime($controlDate));
        $this->timeCreatedRefl->setValue($this->object, new DateTime($dateCreated));

        $this->assertEquals($expected, $this->object->isExpired());

        // double assertion to check for DateTime hasn't been cloned properly before substraction
        $this->assertEquals($expected, $this->object->isExpired());
    }
}