<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\DevMasterAliasUpdater;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

/**
 * @see https://github.com/symplify/monorepo-builder/blob/main/packages/Release/ReleaseWorker/UpdateBranchAliasReleaseWorker.php
 */
final class UpdateBranchAliasReleaseWorker extends AbstractPrepareReleaseBranchWorker
{
	public function __construct(
		public ProcessRunner $processRunner,
		public ComposerJsonProvider $composerJsonProvider,
		private readonly DevMasterAliasUpdater $devMasterAliasUpdater,
		private readonly VersionUtils $versionUtils
	)
	{
		parent::__construct($processRunner, $composerJsonProvider);
	}


	public function work(Version $version): void
	{
		$nextAlias = $this->versionUtils->getNextAliasFormat($version);
		$this->devMasterAliasUpdater->updateFileInfosWithAlias(
			$this->composerJsonProvider->getPackagesComposerFileInfos(),
			$nextAlias
		);
	}


	public function getDescription(Version $version): string
	{
		$nextAlias = $this->versionUtils->getNextAliasFormat($version);

		return sprintf('Set branch alias "%s" to all packages', $nextAlias);
	}
}
