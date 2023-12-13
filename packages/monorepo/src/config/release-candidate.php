<?php declare(strict_types = 1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->workers([
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\CreatePrepareReleaseBranchWorker::class,
		//TODO check zda jsem opravdu na release větvi (release-x.x.x)
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\UpdateReplaceReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\SetCurrentMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\WriteApplicationVersionWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\SetNextMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\UpdateComposerLockWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\CommitPrepareReleaseWorker::class,
		//TODO \AloisJasa\Monorepo\Worker\ReleaseCandidate\TagRCVersionReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\PushPrepareReleaseBranchWorker::class,
		//TODO \AloisJasa\Monorepo\Worker\ReleaseCandidate\PushTagReleaseWorker::class,
	]);
};
