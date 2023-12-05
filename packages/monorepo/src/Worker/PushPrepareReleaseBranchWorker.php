<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;


use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Throwable;
final class PushPrepareReleaseBranchWorker implements ReleaseWorkerInterface
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
			$gitAddCommitCommand = \sprintf('git push --set-upstream origin "%s"', $branchName);
			$this->processRunner->run($gitAddCommitCommand);
		} catch (\Throwable $exception) {
			// nothing to commit
		}
	}
	public function getDescription(Version $version) : string
	{
		return \sprintf('Push prepare release branch for version "%s" to remote.', $version->getOriginalString());
	}
}
