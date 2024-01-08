<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Throwable;

final class CreateReleaseBranchWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{
		try {
			$sourceTag = $this->prepareReleaseTagName($version->getOriginalString());
			$gitAddCommitCommand = sprintf('git checkout -b "%s" tags/%s', $this->releaseBranchName($version), $sourceTag);
			$this->processRunner->run($gitAddCommitCommand);
		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Create new prepare release branch "%s" for version "%s"',
			$this->releaseBranchName($version),
			$version->getOriginalString(),
		);
	}
}
