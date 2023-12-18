<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Patch;

use PharIo\Version\Version;
use Throwable;

final class CommitPrepareReleaseWorker extends AbstractPatchWorker
{
	public function work(Version $version): void
	{
		try {
			$this->commit("commit patch");
			$this->processRunner->run("git push");
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return 'Commit prepare release files"';
	}
}
