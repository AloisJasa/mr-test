<?php declare(strict_types = 1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->workers([
		\AloisJasa\Monorepo\Worker\OpenDev\CheckoutMainWorker::class,
		//TODO check zda jsem opravdu na default větvi (master/main)
		\AloisJasa\Monorepo\Worker\OpenDev\SetNextMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\OpenDev\UpdateBranchAliasReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\OpenDev\UpdateComposerLockWorker::class,
		\AloisJasa\Monorepo\Worker\OpenDev\PushNextDevReleaseWorker::class,
	]);
};
