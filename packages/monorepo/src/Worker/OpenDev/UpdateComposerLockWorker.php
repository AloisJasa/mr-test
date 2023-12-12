<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\OpenDev;

use PharIo\Version\Version;

class UpdateComposerLockWorker extends AbstractOpenDevWorker
{
	public function work(Version $version): void
	{
		$this->processRunner->run('composer update --lock && git add composer.lock');
	}


	public function getDescription(Version $version): string
	{
		return 'Update composer.lock to be in sync with composer.json';
	}
}
