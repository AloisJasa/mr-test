<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;

use MonorepoBuilder202211\Symfony\Component\Process\Process;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\StageAwareInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

abstract class AbstractWorker implements StageAwareInterface
{
	protected ?ProcessRunner $processRunner = null;

	private string $currentBranchName;


	/**
	 * @required
	 */
	public function setup(
		ProcessRunner $processRunner,
	): void {
		$this->processRunner = $processRunner;
		$this->currentBranchName = $this->getProcessResult(['git', 'rev-parse', '--abbrev-ref', 'HEAD']);
	}


	protected function prepareReleaseBranchName(string $version): string
	{
		return sprintf("%s-%s", 'prepare-release', $version);
	}


	protected function commit(string $message): void
	{
		$this->processRunner->run('git add .');
		$this->processRunner->run('git commit --message="' . addslashes($message) . '"');
	}


	/**
	 * @param string[] $commandLine
	 * @return string
	 */
	protected function getProcessResult(array $commandLine): string
	{
		$process = new Process($commandLine);
		$process->run();

		return trim($process->getOutput());
	}
}
