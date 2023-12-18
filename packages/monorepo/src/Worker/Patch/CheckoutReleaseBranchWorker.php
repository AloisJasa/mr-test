<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Patch;

use PharIo\Version\Version;

final class CheckoutReleaseBranchWorker extends AbstractPatchWorker
{
	public function work(Version $version) : void
	{
		$gitCheckoutMaster = sprintf(
			'git fetch && git checkout %s',
			$this->prepareReleaseBranchName(
				sprintf(
					"%s.%s.%s",
					$version->getMajor()->getValue(),
					$version->getMinor()->getValue(),
					0,
				)
			)
		);
		$this->processRunner->run($gitCheckoutMaster);
	}


	public function getDescription(Version $version) : string
	{
		return sprintf('Checkout default branch "%s".', $this->getDefaultBranch());
	}
}
