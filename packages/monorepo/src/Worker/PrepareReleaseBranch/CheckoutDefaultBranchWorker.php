<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;

final class CheckoutDefaultBranchWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version) : void
	{
		$gitCheckoutMaster = sprintf('git fetch && git checkout %s', $this->getDefaultBranch());
		$this->processRunner->run($gitCheckoutMaster);
	}


	public function getDescription(Version $version) : string
	{
		return sprintf('Checkout default branch "%s".', $this->getDefaultBranch());
	}
}
