<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\PrepareReleaseBranch;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractWorker;

abstract class AbstractPrepareReleaseBranchWorker extends AbstractWorker
{
	final public function getStage(): string
	{
		return Stage::PREPARE_RELEASE_BRANCH->value;
	}
}
