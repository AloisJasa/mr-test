<?php declare(strict_types = 1);


namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\DependencyUpdater;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Package\PackageNamesProvider;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

class SetCurrentMutualDependenciesReleaseWorker extends AbstractReleaseWorker
{
	private VersionUtils $versionUtils;

	private DependencyUpdater $dependencyUpdater;

	private ComposerJsonProvider $composerJsonProvider;

	private PackageNamesProvider $packageNamesProvider;


	public function __construct(
		VersionUtils $versionUtils,
		DependencyUpdater $dependencyUpdater,
		ComposerJsonProvider $composerJsonProvider,
		PackageNamesProvider $packageNamesProvider
	)
	{
		$this->versionUtils = $versionUtils;
		$this->dependencyUpdater = $dependencyUpdater;
		$this->composerJsonProvider = $composerJsonProvider;
		$this->packageNamesProvider = $packageNamesProvider;
	}


	public function work(Version $version): void
	{
		$versionInString = $this->versionUtils->getRequiredFormat($version);
		$this->dependencyUpdater->updateFileInfosWithPackagesAndVersion(
			$this->composerJsonProvider->getPackagesComposerFileInfos(),
			$this->packageNamesProvider->provide(),
			$versionInString
		);
		// give time to propagate values before commit
		\sleep(1);
	}


	public function getDescription(Version $version): string
	{
		$versionInString = $this->versionUtils->getRequiredFormat($version);

		return \sprintf('Set packages mutual dependencies to "%s" version', $versionInString);
	}


	public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
