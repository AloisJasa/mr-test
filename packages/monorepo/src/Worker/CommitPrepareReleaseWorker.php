<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;


use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Throwable;
final class CommitPrepareReleaseWorker implements ReleaseWorkerInterface
{
	/**
	 * @var ProcessRunner
	 */
	private $processRunner;
	public function __construct(ProcessRunner $processRunner,ParameterProvider $parameterProvider)
	{
		$this->processRunner = $processRunner;
	}
	public function work(Version $version) : void
	{
		try {
			$gitAddCommitCommand = 'git add . && git commit -m "prepare release"';
			$this->processRunner->run($gitAddCommitCommand);
		} catch (\Throwable $exception) {
			// nothing to commit
		}
	}

	public function getDescription(Version $version) : string
	{
		return 'Commit prepare release files"';
	}
}
