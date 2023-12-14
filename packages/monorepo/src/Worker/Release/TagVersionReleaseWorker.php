<?php declare(strict_types=1);

namespace AloisJasa\Monorepo\Worker\Release;

use PharIo\Version\Version;

final class TagVersionReleaseWorker extends AbstractReleaseWorker
{
	public function work(Version $version): void
	{
		$this->processRunner->run('git tag ' . $this->releaseCandidateTagName($version->getOriginalString()));
	}


	public function getDescription(Version $version): string
	{
		return sprintf('Add local tag "%s"', $this->releaseCandidateTagName($version->getOriginalString()));
	}
}
