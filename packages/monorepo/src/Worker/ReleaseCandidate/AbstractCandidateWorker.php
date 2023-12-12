<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractWorker;

abstract class AbstractCandidateWorker extends AbstractWorker
{
	final public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
