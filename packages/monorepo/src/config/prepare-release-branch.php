<?php declare(strict_types = 1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->workers([
		//TODO check jedná se o minor/major

		// 1.create branch
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\CreatePrepareReleaseBranchWorker::class,

		// 2.commit prepare-commit
		//TODO check zda jsem opravdu na release větvi (release-x.x.x) jinak konec
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\UpdateReplaceReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\SetCurrentMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\WriteApplicationVersionWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\UpdateComposerLockWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\CommitPrepareCommitWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\AddPrepareReleaseTagWorker::class,

		// 3.commit open-dev
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\SetNextMutualDependenciesReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\UpdateBranchAliasReleaseWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\CommitOpenDevWorker::class,

		// 4. push
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\PushPrepareReleaseBranchWorker::class,

		// 5. merge prepare branch
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\CheckoutDefaultBranchWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\MergePrepareBranchWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\PushPrepareReleaseTagWorker::class,

		// 6. create release branch
		// TODO check zda tag existuje
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\CreateReleaseBranchWorker::class,
		// TODO check zda jsem opravdu na správně větvi

		// 7. commit release candidate commit
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\CommitEmptyToReleaseBranchWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\PushReleaseBranchWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\AddReleaseTagWorker::class,
		\AloisJasa\Monorepo\Worker\PrepareReleaseBranch\PushReleaseTagWorker::class,
	]);
};
