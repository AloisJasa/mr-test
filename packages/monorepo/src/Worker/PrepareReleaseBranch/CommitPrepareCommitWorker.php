<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Throwable;

final class CommitPrepareCommitWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{
		try {
			$this->commit(sprintf(
				'Prepare release files for version "%s"',
				$version->getOriginalString(),
			));
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Commit prepare release files for version "%s"',
			$version->getOriginalString(),
		);
	}
}
