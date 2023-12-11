<?php

declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\DependencyUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final class SetNextMutualDependenciesReleaseWorker extends AbstractReleaseWorker
{
	private ComposerJsonProvider $composerJsonProvider;

	private DependencyUpdater $dependencyUpdater;

	private PackageNamesProvider $packageNamesProvider;

	private VersionUtils $versionUtils;


	public function __construct(
		ComposerJsonProvider $composerJsonProvider,
		DependencyUpdater $dependencyUpdater,
		PackageNamesProvider $packageNamesProvider,
		VersionUtils $versionUtils
	)
	{
		$this->composerJsonProvider = $composerJsonProvider;
		$this->dependencyUpdater = $dependencyUpdater;
		$this->packageNamesProvider = $packageNamesProvider;
		$this->versionUtils = $versionUtils;
	}


	public function work(Version $version): void
	{
		$versionInString = $this->versionUtils->getRequiredNextFormat($version);
		$this->dependencyUpdater->updateFileInfosWithPackagesAndVersion(
			$this->composerJsonProvider->getPackagesComposerFileInfos(),
			$this->packageNamesProvider->provide(),
			$versionInString
		);
	}


	public function getDescription(Version $version): string
	{
		$versionInString = $this->versionUtils->getRequiredNextFormat($version);

		return \sprintf('Set packages mutual dependencies to "%s" (alias of dev version)', $versionInString);
	}


	public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
