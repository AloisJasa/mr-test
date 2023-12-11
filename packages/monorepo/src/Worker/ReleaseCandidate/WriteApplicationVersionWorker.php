<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final class WriteApplicationVersionWorker extends AbstractReleaseWorker
{
	public function __construct(
		private readonly ProcessRunner $processRunner
	)
	{
	}


	public function work(Version $version): void
	{
		$gitAddCommitCommand = \sprintf('echo %s > app_version', $version->getOriginalString());
		$this->processRunner->run($gitAddCommitCommand);
	}


	public function getDescription(Version $version): string
	{
		return \sprintf('Write current version "%s" to app_version file.', $version->getOriginalString());
	}


	public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
