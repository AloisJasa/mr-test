<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;



use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

final class CreatePrepareReleaseBranchWorker implements ReleaseWorkerInterface
{
	/**
	 * @var ProcessRunner
	 */
	private $processRunner;
	public function __construct(ProcessRunner $processRunner, ParameterProvider $parameterProvider)
	{
		$this->processRunner = $processRunner;
	}
	public function work(Version $version) : void
	{
		$branchName = sprintf("prepare-release-%s", $version->getOriginalString());

		try {
			$gitAddCommitCommand = \sprintf('git checkout -b "%s"', $branchName);
			$this->processRunner->run($gitAddCommitCommand);
		} catch (\Throwable $exception) {
			// nothing to commit
		}
	}
	public function getDescription(Version $version) : string
	{
		return \sprintf('Create new prepare release branch for version "%s"', $version->getOriginalString());
	}
}
