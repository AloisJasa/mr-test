<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use PharIo\Version\Version;
use Throwable;

final class PushPrepareReleaseBranchWorker extends AbstractCandidateWorker
{
	public function work(Version $version): void
	{
		try {
			$gitAddCommitCommand = sprintf('git push --set-upstream origin "%s"', $this->prepareReleaseBranchName($version->getOriginalString()));
			$this->processRunner->run($gitAddCommitCommand);
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Push prepare release branch "%s" for version "%s" to remote.',
			$this->prepareReleaseBranchName($version->getOriginalString()),
			$version->getOriginalString(),
		);
	}
}
