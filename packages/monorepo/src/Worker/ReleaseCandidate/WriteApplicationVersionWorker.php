<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use PharIo\Version\Version;

final class WriteApplicationVersionWorker extends AbstractCandidateWorker
{
	public function work(Version $version): void
	{
		$gitAddCommitCommand = sprintf('echo %s > app_version', $version->getOriginalString());
		$this->processRunner->run($gitAddCommitCommand);
	}


	public function getDescription(Version $version): string
	{
		return sprintf('Write current version "%s" to app_version file.', $version->getOriginalString());
	}
}
