<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker;

use Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use Symplify\MonorepoBuilder\Release\Process\ProcessRunner;
use Symplify\MonorepoBuilder\Utils\VersionUtils;
final class OpenDevCommitWorker implements ReleaseWorkerInterface
{
	/**
	 * @var ProcessRunner
	 */
	private $processRunner;
	/**
	 * @var VersionUtils
	 */
	private $versionUtils;
	public function __construct(ProcessRunner $processRunner, VersionUtils $versionUtils)
	{
		$this->processRunner = $processRunner;
		$this->versionUtils = $versionUtils;
	}
	public function work(\PharIo\Version\Version $version) : void
	{

	}
	public function getDescription(\PharIo\Version\Version $version) : string
	{
		return \sprintf('Write current version "%s" to app_version file.', $version->getOriginalString());
	}
}
