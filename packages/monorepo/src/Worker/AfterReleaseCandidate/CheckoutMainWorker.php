<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\AfterReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use AloisJasa\Monorepo\Worker\AbstractReleaseWorker;
use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
use Symplify\MonorepoBuilder\ValueObject\Option;

final class CheckoutMainWorker extends AbstractReleaseWorker
{
	public function __construct(
		private readonly ProcessRunner $processRunner,
		private readonly ParameterProvider $parameterProvider,
	)
	{
	}


	public function work(Version $version) : void
	{
		$gitCheckoutMaster = sprintf('git fetch && git checkout %s', $this->getDefaultBranch());
		$this->processRunner->run($gitCheckoutMaster);
	}


	public function getDescription(Version $version) : string
	{
		return sprintf('Checkout default branch.', $this->getDefaultBranch());
	}


	public function getStage(): string
	{
		return Stage::AFTER_RELEASE_CANDIDATE->value;
	}


	private function getDefaultBranch(): string
	{
		return $this->parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
	}
}
