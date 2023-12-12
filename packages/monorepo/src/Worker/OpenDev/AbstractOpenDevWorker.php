<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\OpenDev;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractWorker;

abstract class AbstractOpenDevWorker extends AbstractWorker
{
	final public function getStage(): string
	{
		return Stage::OPEN_DEV->value;
	}
}
