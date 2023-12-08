<?php declare(strict_types = 1);

use AloisJasa\Monorepo\Worker\CheckoutMainWorker;
use AloisJasa\Monorepo\Worker\CommitNextDevReleaseWorker;
use AloisJasa\Monorepo\Worker\CommitPrepareReleaseWorker;
use AloisJasa\Monorepo\Worker\CreatePrepareReleaseBranchWorker;
use AloisJasa\Monorepo\Worker\PushPrepareReleaseBranchWorker;
use AloisJasa\Monorepo\Worker\UpdateComposerLockWorker;
use AloisJasa\Monorepo\Worker\WriteApplicationVersionWorker;
use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\AddTagToChangelogReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushNextDevReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\PushTagReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetCurrentMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\SetNextMutualDependenciesReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\TagVersionReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateBranchAliasReleaseWorker;
use Symplify\MonorepoBuilder\Release\ReleaseWorker\UpdateReplaceReleaseWorker;

return static function (MBConfig $mbConfig): void {
	$mbConfig->packageDirectories([
		__DIR__ . '/packages',
	]);

	$mbConfig->defaultBranch('main');

	$mbConfig->workers([

		// git fetch
		// git checkout main
		// git pull


// --------------- prepare brach start
		//git checkout -b prepare-release-x.x.x
		CreatePrepareReleaseBranchWorker::class, // NEW

		UpdateReplaceReleaseWorker::class,
		SetCurrentMutualDependenciesReleaseWorker::class,
		WriteApplicationVersionWorker::class,// NEW

		SetNextMutualDependenciesReleaseWorker::class,

		CommitPrepareReleaseWorker::class,// NEW
		PushPrepareReleaseBranchWorker::class,// NEW

// --------------- prepare branch finish

// --------------- open-dev-commit start
		// git checkout main

		//		UpdateComposerLockWorker::class, // -
		//		TagVersionReleaseWorker::class, // -
		//		PushTagReleaseWorker::class, // -
		//		PushNextDevReleaseWorker::class, // -

		CheckoutMainWorker::class,
		UpdateBranchAliasReleaseWorker::class,
		PushNextDevReleaseWorker::class,
		// --------------- open-dev-commit start
		//		\AloisJasa\Monorepo\Worker\OpenDevCommitWorker::class, // NEW
//		CommitNextDevReleaseWorker::class,// NEW
	]);
};
