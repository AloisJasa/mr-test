<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\OpenDev;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\DevMasterAliasUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final class UpdateBranchAliasReleaseWorker extends AbstractOpenDevWorker
{
	public function __construct(
		private readonly DevMasterAliasUpdater $devMasterAliasUpdater,
		private readonly ComposerJsonProvider $composerJsonProvider,
		private readonly VersionUtils $versionUtils
	)
	{
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
