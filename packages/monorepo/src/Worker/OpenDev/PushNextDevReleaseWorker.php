<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\OpenDev;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

final class PushNextDevReleaseWorker extends AbstractOpenDevWorker
{
	public function __construct(
		private readonly VersionUtils $versionUtils,
	)
	{
	}


	public function work(Version $version): void
	{
		$versionInString = $this->getVersionDev($version);
		$this->commit(sprintf("open %s", $versionInString));
		$this->processRunner->run("git push");
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
