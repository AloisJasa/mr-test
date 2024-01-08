<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Throwable;

final class PushReleaseBranchWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{
		try {
			$this->processRunner->run(
				sprintf(
					'git push --set-upstream origin "%s"',
					$this->releaseBranchName($version),
				)
			);
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Push release branch "%s" for version "%s" to remote.',
			$this->releaseBranchName($version),
			$version->getOriginalString(),
		);
	}
}
