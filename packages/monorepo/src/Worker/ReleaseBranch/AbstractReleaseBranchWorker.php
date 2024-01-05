<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseBranch;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractWorker;

abstract class AbstractReleaseBranchWorker extends AbstractWorker
{
	final public function getStage(): string
	{
		return Stage::RELEASE_BRANCH->value;
	}
}
