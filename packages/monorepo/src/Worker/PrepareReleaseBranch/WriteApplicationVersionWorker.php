<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;

final class WriteApplicationVersionWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{

		$this->processRunner->run(sprintf('echo %s > app_version', $version->getOriginalString()));
		foreach ($this->providePackagesShortNames() as $package) {
			$this->processRunner->run(
				sprintf('echo %s > packages/%s/app_version', $version->getOriginalString(), $package)
			);
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf('Write current version "%s" to app_version file.', $version->getOriginalString());
	}
}
