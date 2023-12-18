<?php declare (strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Patch;

use PharIo\Version\Version;

final class PushTagReleaseWorker extends AbstractPatchWorker
{
	public function work(Version $version): void
	{
		$this->processRunner->run('git push --tags');
	}


	public function getDescription(Version $version): string
	{
		return \sprintf('Push "%s" tag to remote repository', $version->getVersionString());
	}
}
