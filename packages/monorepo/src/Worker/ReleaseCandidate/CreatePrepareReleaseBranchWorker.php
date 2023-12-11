<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Throwable;

final class CreatePrepareReleaseBranchWorker extends AbstractReleaseWorker
{
	public function __construct(
		private readonly ProcessRunner $processRunner)
	{
	}


	public function work(Version $version): void
	{
		$branchName = sprintf("%s-%s", 'prepare-release', $version->getOriginalString());

		try {
			$gitAddCommitCommand = sprintf('git checkout -b "%s"', $branchName);
			$this->processRunner->run($gitAddCommitCommand);
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return \sprintf('Create new prepare release branch for version "%s"', $version->getOriginalString());
	}


	public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
