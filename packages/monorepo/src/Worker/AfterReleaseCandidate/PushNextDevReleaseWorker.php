<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\AfterReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\MonorepoBuilder\ValueObject\Option;
use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;

final class PushNextDevReleaseWorker extends AbstractReleaseWorker
{
	private string $branchName;

	private ProcessRunner $processRunner;

	private VersionUtils $versionUtils;


	public function __construct(
		ProcessRunner $processRunner,
		VersionUtils $versionUtils,
		ParameterProvider $parameterProvider
	)
	{
		$this->processRunner = $processRunner;
		$this->versionUtils = $versionUtils;
		$this->branchName = $parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
	}


	public function work(Version $version): void
	{
		$versionInString = $this->getVersionDev($version);
		$gitAddCommitCommand = \sprintf(
			'git add . && git commit --allow-empty -m "open %s" && git push origin "%s"',
			$versionInString,
			$this->branchName
		);
		$this->processRunner->run($gitAddCommitCommand);
	}


	public function getDescription(Version $version): string
	{
		$versionInString = $this->getVersionDev($version);

		return \sprintf('Push "%s" open to remote repository', $versionInString);
	}


	private function getVersionDev(Version $version): string
	{
		return $this->versionUtils->getNextAliasFormat($version);
	}


	public function getStage(): string
	{
		return Stage::AFTER_RELEASE_CANDIDATE->value;
	}
}
