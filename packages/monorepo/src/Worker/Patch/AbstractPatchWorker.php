<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\Patch;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractWorker;

abstract class AbstractPatchWorker extends AbstractWorker
{
	final public function getStage(): string
	{
		return Stage::PATCH->value;
	}
}
