<?php declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->workers([
		\AloisJasa\Monorepo\Worker\Release\CheckoutReleaseBranchWorker::class,
		//TODO check zda jsem opravdu na release větvi (master/main)
		\AloisJasa\Monorepo\Worker\Release\TagVersionReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Release\PushTagReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Release\CheckoutMainWorker::class,
		//TODO check zda jsem opravdu na default větvi (master/main)
		\AloisJasa\Monorepo\Worker\Release\MergeReleaseBranchWorker::class,
	]);
};
