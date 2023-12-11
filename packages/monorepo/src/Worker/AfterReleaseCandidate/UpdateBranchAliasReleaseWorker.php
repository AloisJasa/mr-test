<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\AfterReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\DevMasterAliasUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final class UpdateBranchAliasReleaseWorker extends AbstractReleaseWorker
{
	private DevMasterAliasUpdater $devMasterAliasUpdater;

	private ComposerJsonProvider $composerJsonProvider;

	private VersionUtils $versionUtils;


	public function __construct(
		DevMasterAliasUpdater $devMasterAliasUpdater,
		ComposerJsonProvider $composerJsonProvider,
		VersionUtils $versionUtils
	)
	{
		$this->devMasterAliasUpdater = $devMasterAliasUpdater;
		$this->composerJsonProvider = $composerJsonProvider;
		$this->versionUtils = $versionUtils;
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

		return \sprintf('Set branch alias "%s" to all packages', $nextAlias);
	}


	public function getStage(): string
	{
		return Stage::AFTER_RELEASE_CANDIDATE->value;
	}
}
