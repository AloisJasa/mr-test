<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\DependencyUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final class SetNextMutualDependenciesReleaseWorker extends AbstractCandidateWorker
{
	public function __construct(
		private readonly ComposerJsonProvider $composerJsonProvider,
		private readonly DependencyUpdater $dependencyUpdater,
		private readonly PackageNamesProvider $packageNamesProvider,
		private readonly VersionUtils $versionUtils
	)
	{
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

		return sprintf('Set packages mutual dependencies to "%s" (alias of dev version)', $versionInString);
	}
}
