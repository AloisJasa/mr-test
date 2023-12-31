<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\OpenDev;

use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Utils\VersionUtils;

/**
 * @see https://github.com/symplify/monorepo-builder/blob/main/packages/Release/ReleaseWorker/PushNextDevReleaseWorker.php
 */
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
		$this->processRunner->run("git push"); //TODO push origin main ?
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
