<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Release;

use PharIo\Version\Version;

final class CheckoutReleaseBranchWorker extends AbstractReleaseWorker
{
	public function work(Version $version) : void
	{
		$gitCheckoutMaster = sprintf('git fetch && git checkout %s', $this->prepareReleaseBranchName($version));
		$this->processRunner->run($gitCheckoutMaster);
	}


	public function getDescription(Version $version) : string
	{
		return sprintf('Checkout default branch "%s".', $this->getDefaultBranch());
	}
}
