<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;

use MonorepoBuilder202211\Symfony\Component\Process\Process;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\StageAwareInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

abstract class AbstractWorker implements StageAwareInterface
{
	protected ?ProcessRunner $processRunner = null;


	/**
	 * @required
	 */
	public function setup(
		ProcessRunner $processRunner,
	): void {
		$this->processRunner = $processRunner;
	}


	protected function prepareReleaseBranchName(string $version): string
	{
		return sprintf("%s-%s", 'release', $version);
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

	protected function getCurrentBranch(): ?string
	{
		exec('git rev-parse --abbrev-ref HEAD',$outputs,$result_code);

		return $result_code === 0 ? $outputs[0] : null;
	}

	protected function getDefaultBranch(): ?string
	{
		exec('git remote set-head origin -a');
		exec("git symbolic-ref --short refs/remotes/origin/HEAD | cut -d '/' -f 2",$outputs,$result_code);

		return $result_code === 0 ? $outputs[0] ?? null : null;
	}


	protected function releaseCandidateTagName(string $version): string
	{
		return sprintf(
			'%s-%s',
			$version,
			'rc',
		);
	}
}
