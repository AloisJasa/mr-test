<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use PharIo\Version\Version;
use Throwable;

final class CreateReleaseBranchWorker extends AbstractPrepareReleaseBranchWorker
{
	public function work(Version $version): void
	{
		try {
			$releaseBranch = $version->getOriginalString();
			$sourceTag = $this->prepareReleaseTagName($version->getOriginalString());
			$gitAddCommitCommand = sprintf('git checkout -b "%s" tags/%s', $releaseBranch, $sourceTag);
			$this->processRunner->run($gitAddCommitCommand);

			$this->processRunner->run('git commit --message="release" --allow-empty');

			$gitCommitCommand = sprintf(
				'git push --set-upstream origin "%s"',
				$releaseBranch,
			);
			$this->processRunner->run($gitCommitCommand);

		} catch (Throwable $exception) {
			// nothing to commit
		}
	}


	public function getDescription(Version $version): string
	{
		return sprintf(
			'Create new prepare release branch "%s" for version "%s"',
			$this->prepareReleaseBranchName($version->getOriginalString()),
			$version->getOriginalString(),
		);
	}
}
