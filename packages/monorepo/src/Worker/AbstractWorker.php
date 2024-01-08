<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;

use MonorepoBuilder202211\Nette\Utils\Strings;
use MonorepoBuilder202211\Symfony\Component\Process\Process;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\StageAwareInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;

abstract class AbstractWorker implements StageAwareInterface
{
	protected ?ProcessRunner $processRunner = null;
	protected ?ComposerJsonProvider $composerJsonProvider = null;


	/**
	 * @required
	 */
	public function setup(
		ProcessRunner $processRunner,
		ComposerJsonProvider $composerJsonProvider,
	): void {
		$this->processRunner = $processRunner;
		$this->composerJsonProvider = $composerJsonProvider;
	}


	protected function prepareReleaseBranchName(Version $version): string
	{
		return sprintf("v%s.%s-%s", $version->getMajor()->getValue(), $version->getMinor()->getValue(), 'prepare');
	}


	protected function releaseBranchName(Version $version): string
	{
		return sprintf("%s%s.%s", 'v', $version->getMajor()->getValue(), $version->getMinor()->getValue());
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


	protected function prepareReleaseTagName(string $version): string
	{
		return sprintf(
			'v%s-%s',
			$version,
			'prepare',
		);
	}


	protected function releaseCandidateTagName(string $version): string
	{
		return sprintf(
			'%s-%s',
			$version,
			'rc',
		);
	}


	protected function providePackagesShortNames(): array
	{
		return array_map(static function($name){
			return (string) Strings::after($name, '/', -1);
		},
			$this->composerJsonProvider->getPackageNames()
		);
	}
}
