<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;


use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

final class CommitPrepareReleaseWorker extends AbstractReleaseWorker
{
	private ProcessRunner $processRunner;


	public function __construct(ProcessRunner $processRunner, ParameterProvider $parameterProvider)
	{
		$this->processRunner = $processRunner;
	}


	public function work(Version $version): void
	{
		try {
			$gitAddCommitCommand = 'git add . && git commit -m "prepare release"';
			$this->processRunner->run($gitAddCommitCommand);
		} catch (\Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return 'Commit prepare release files"';
	}


	public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
