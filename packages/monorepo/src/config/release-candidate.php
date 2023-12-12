<?php declare(strict_types = 1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->workers([
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\CreatePrepareReleaseBranchWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\UpdateReplaceReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\SetCurrentMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\WriteApplicationVersionWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\SetNextMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\UpdateComposerLockWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\CommitPrepareReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\ReleaseCandidate\PushPrepareReleaseBranchWorker::class,
	]);
};
