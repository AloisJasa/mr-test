<?php declare(strict_types=1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;

final class ReleaseTagVersionReleaseWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{
		$this->processRunner->run('git tag ' . $version->getOriginalString());
	}


	public function getDescription(Version $version): string
	{
		return sprintf('Add local tag "%s"', $version->getOriginalString());
	}
}
