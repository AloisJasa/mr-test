<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Throwable;

final class CommitEmptyToReleaseBranchWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{
		try {
			$this->processRunner->run(
				sprintf(
					'git commit --message="Release candidate %s" --allow-empty',
					$version->getOriginalString(),
				)
			);
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Commit empty release candidate commit for version "%s"',
			$version->getOriginalString(),
		);
	}
}
