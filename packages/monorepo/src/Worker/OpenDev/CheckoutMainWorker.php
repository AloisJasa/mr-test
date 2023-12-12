<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\OpenDev;

use MonorepoBuilder202211\Symplify\PackageBuilder\Parameter\ParameterProvider;
use PharIo\Version\Version;
use Symplify\MonorepoBuilder\ValueObject\Option;

final class CheckoutMainWorker extends AbstractOpenDevWorker
{
	public function __construct(
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


	private function getDefaultBranch(): string
	{
		return $this->parameterProvider->provideStringParameter(Option::DEFAULT_BRANCH_NAME);
	}
}
