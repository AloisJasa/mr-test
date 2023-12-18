<?php declare(strict_types = 1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->workers([
		\AloisJasa\Monorepo\Worker\Patch\CheckoutReleaseBranchWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\UpdateReplaceReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\SetCurrentMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\WriteApplicationVersionWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\SetNextMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\UpdateBranchAliasReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\UpdateComposerLockWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\CommitPrepareReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\TagRCVersionReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\Patch\PushTagReleaseWorker::class,
	]);
};
