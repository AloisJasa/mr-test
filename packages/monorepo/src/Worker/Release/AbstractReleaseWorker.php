<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Release;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractWorker;

abstract class AbstractReleaseWorker extends AbstractWorker
{
	final public function getStage(): string
	{
		return Stage::RELEASE->value;
	}
}
