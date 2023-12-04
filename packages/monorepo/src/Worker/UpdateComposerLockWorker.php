<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

class UpdateComposerLockWorker implements ReleaseWorkerInterface
{
	private ProcessRunner $processRunner;


	public function __construct(
		ProcessRunner $processRunner
	)
	{
		$this->processRunner = $processRunner;
	}


	public function work(Version $version): void
	{
		$this->processRunner->run('composer update --lock && git add composer.lock');
	}


	public function getDescription(Version $version): string
	{
		return 'Update composer.lock to be in sync with composer.json';
	}
}
