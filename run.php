#!/usr/bin/env php
<?php
declare(strict_types=1);

use Casadatos\Component\Dashboard\ConsoleDashboard;
use Casadatos\Component\Dashboard\Gauge\ValueGauge;
use Coff\TestAssignment\Action\DeliveryAction;
use Coff\TestAssignment\Asset\Asset;
use Coff\TestAssignment\Asset\AssetBuilder;
use Coff\TestAssignment\Action\RideshareAction;
use Coff\TestAssignment\Asset\AssetRegistry;
use Coff\TestAssignment\Booster\DeliveriesBooster;
use Coff\TestAssignment\Booster\RidesharesBooster;

require __DIR__ . '/vendor/autoload.php';

$dashboard = new ConsoleDashboard();
$dashboard->add("assetName", new ValueGauge(40));
$dashboard->add("pointsEarned", new ValueGauge(15));
$dashboard->add("status", new ValueGauge(9));

$anyPointInTime = new \DateTime('2022-02-25 10:00:00');

$builder = new AssetBuilder();
$builder
    ->setTimeCurrent( $anyPointInTime );

$registry = new AssetRegistry();
$registry->setBoosterTemplate(RideshareAction::class, $ridesharesTpl = new RidesharesBooster());
$registry->setBoosterTemplate(DeliveryAction::class, $deliveriesTpl = new DeliveriesBooster());

$ridesharesTpl->setTimeCurrent($anyPointInTime);
$deliveriesTpl->setTimeCurrent($anyPointInTime);

// use builder pattern just to feed actions with 'any point in time' as dependency
$registry
    ->add($builder->build(RideshareAction::class, new DateTime('2022-01-20 19:01:00')))
    ->add($builder->build(RideshareAction::class, new DateTime('2022-01-20 19:04:00')))
    ->add($builder->build(RideshareAction::class, new DateTime('2022-01-20 20:11:00')))
    ->add($builder->build(RideshareAction::class, new DateTime('2022-01-20 21:11:00')))
    ->add($builder->build(RideshareAction::class, new DateTime('2022-01-20 22:11:00')))
;

$registry
    ->add($builder->build(DeliveryAction::class, new DateTime('2022-01-20 19:35:00')))
    ->add($builder->build(DeliveryAction::class, new DateTime('2022-01-20 19:57:00')))
    ->add($builder->build(DeliveryAction::class, new DateTime('2022-01-20 20:40:00')))
    ->add($builder->build(DeliveryAction::class, new DateTime('2022-01-20 20:56:00')))
    ->add($builder->build(DeliveryAction::class, new DateTime('2022-01-20 21:11:00')))
;

echo 'Point in time: ' . $anyPointInTime->format('M, d H:i') . PHP_EOL;

$dashboard
    ->init()
    ->printHeaders();

/** @var Asset $asset */
foreach ($registry->getAssets() as $asset) {
    $dashboard->update('assetName', $asset->getName() );
    $dashboard->update('pointsEarned', $asset->getPointsEarned() );
    $dashboard->update('status', $asset->isExpired() ? 'expired' : 'valid' );
    $dashboard->refresh(true);
    $dashboard->snap();
}

$dashboard->summarize();

echo 'Overall points earned: ' . $registry->getPointBalance();

$dashboard->summarize();



