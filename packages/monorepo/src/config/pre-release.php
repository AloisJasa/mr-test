<?php declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$services = $containerConfigurator->services();

	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\CreatePrepareReleaseBranchWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\UpdateReplaceReleaseWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\SetCurrentMutualDependenciesReleaseWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\WriteApplicationVersionWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\SetNextMutualDependenciesReleaseWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\UpdateComposerLockWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\CommitPrepareReleaseWorker::class);
	$services->set(\AloisJasa\Monorepo\Worker\ReleaseCandidate\PushPrepareReleaseBranchWorker::class);
};
