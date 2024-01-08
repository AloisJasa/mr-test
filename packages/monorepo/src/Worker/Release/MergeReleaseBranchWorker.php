<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Release;

use PharIo\Version\Version;

final class MergeReleaseBranchWorker extends AbstractReleaseWorker
{
	public function work(Version $version) : void
	{
		$gitCheckoutMaster = sprintf(
			'git merge --no-ff -m "Merge %s" %s',
			$this->prepareReleaseBranchName($version),
			$this->prepareReleaseBranchName($version),
		);
		$this->processRunner->run($gitCheckoutMaster);
		$this->processRunner->run("git push");
	}


	public function getDescription(Version $version) : string
	{
		return sprintf('Checkout default branch "%s".', $this->getDefaultBranch());
	}
}
