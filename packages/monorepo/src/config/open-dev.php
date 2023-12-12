<?php declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$services = $containerConfigurator->services();
	$services->set(\AloisJasa\Monorepo\Worker\OpenDev\CheckoutMainWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\OpenDev\SetNextMutualDependenciesReleaseWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\OpenDev\UpdateBranchAliasReleaseWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\OpenDev\UpdateComposerLockWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\OpenDev\PushNextDevReleaseWorker::class);
};
