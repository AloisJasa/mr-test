<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo\Worker\ReleaseCandidate;

use AloisJasa\Monorepo\Stage;
use PharIo\Version\Version;
use MonorepoBuilder202211\Symplify\ComposerJsonManipulator\FileSystem\JsonFileManager;
use Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use Symplify\MonorepoBuilder\Release\Exception\MissingComposerJsonException;
use MonorepoBuilder202211\Symplify\SmartFileSystem\SmartFileInfo;
class UpdateReplaceReleaseWorker extends \AloisJasa\Monorepo\Worker\AbstractReleaseWorker
{
	private ComposerJsonProvider $composerJsonProvider;

	private JsonFileManager $jsonFileManager;
	public function __construct(ComposerJsonProvider $composerJsonProvider, JsonFileManager $jsonFileManager)
	{
		$this->composerJsonProvider = $composerJsonProvider;
		$this->jsonFileManager = $jsonFileManager;
	}
	public function work(Version $version) : void
	{
		$rootComposerJson = $this->composerJsonProvider->getRootComposerJson();
		$replace = $rootComposerJson->getReplace();
		$packageNames = $this->composerJsonProvider->getPackageNames();
		$newReplace = [];
		foreach (\array_keys($replace) as $package) {
			if (!\in_array($package, $packageNames, \true)) {
				continue;
			}
			$newReplace[$package] = $version->getVersionString();
		}
		if ($replace === $newReplace) {
			return;
		}
		$rootComposerJson->setReplace($newReplace);
		$rootFileInfo = $rootComposerJson->getFileInfo();
		if (!$rootFileInfo instanceof SmartFileInfo) {
			throw new MissingComposerJsonException();
		}
		$this->jsonFileManager->printJsonToFileInfo($rootComposerJson->getJsonArray(), $rootFileInfo);
	}
	public function getDescription(Version $version) : string
	{
		return 'Update "replace" version in "composer.json" to new tag to avoid circular dependencies conflicts';
	}

	public function getStage(): string
	{
		return Stage::RELEASE_CANDIDATE->value;
	}
}
