<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;

final class MergePrepareBranchWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version) : void
	{
		$gitCheckoutMaster = sprintf(
			'git merge --no-ff -m "Merge prepare release branch %s" %s',
			$this->prepareReleaseBranchName($version),
			$this->prepareReleaseBranchName($version),
		);
		$this->processRunner->run($gitCheckoutMaster);
		$this->processRunner->run("git push");
	}


	public function getDescription(Version $version) : string
	{
		return sprintf('Merge prepare release branch %s.', $this->prepareReleaseBranchName($version));
	}
}
