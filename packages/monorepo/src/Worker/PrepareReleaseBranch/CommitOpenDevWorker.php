<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

/**
 * @see https://github.com/symplify/monorepo-builder/blob/main/packages/Release/ReleaseWorker/PushNextDevReleaseWorker.php
 */
final class CommitOpenDevWorker extends AbstractPrepareReleaseBranchWorker
{
	public function __construct(
		public ProcessRunner $processRunner,
		public ComposerJsonProvider $composerJsonProvider,
		private readonly VersionUtils $versionUtils,
	)
	{
		parent::__construct($processRunner, $composerJsonProvider);
	}


	public function work(Version $version): void
	{
		$versionInString = $this->getVersionDev($version);
		$this->commit(sprintf("Open %s", $versionInString));
	}


	public function getDescription(Version $version): string
	{
		$versionInString = $this->getVersionDev($version);

		return sprintf('Push "%s" open to remote repository', $versionInString);
	}


	private function getVersionDev(Version $version): string
	{
		return $this->versionUtils->getNextAliasFormat($version);
	}
}
