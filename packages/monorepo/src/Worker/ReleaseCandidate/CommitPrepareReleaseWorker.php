<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use PharIo\Version\Version;
use Throwable;

final class CommitPrepareReleaseWorker extends AbstractCandidateWorker
{
	public function work(Version $version): void
	{
		try {
			$this->commit("prepare release");
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return 'Commit prepare release files"';
	}
}
