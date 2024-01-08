<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseBranch;

use PharIo\Version\Version;
use Throwable;

final class CreatePrepareReleaseBranchWorker extends AbstractReleaseBranchWorker
{
	public function work(Version $version): void
	{
		try {
			$releaseBranch = $version->getOriginalString();
			$sourceTag = $this->prepareReleaseTagName($version->getOriginalString());
			$gitAddCommitCommand = sprintf('git checkout -b "%s" tags/%s', $releaseBranch, $sourceTag);
			$this->processRunner->run($gitAddCommitCommand);
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Create new prepare release branch "%s" for version "%s"',
			$this->prepareReleaseBranchName($version),
			$version->getOriginalString(),
		);
	}
}
