<?php declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;
use Symplify\MonorepoBuilder\ValueObject\Option;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->import(__DIR__ . '/open-dev.php');
	$containerConfigurator->import(__DIR__ . '/release-candidate.php');
	$containerConfigurator->import(__DIR__ . '/release.php');
	$containerConfigurator->import(__DIR__ . '/patch.php');

	$parameters = $containerConfigurator->parameters();

	// require "--stage <name>" when release command is run
	$parameters->set(Option::IS_STAGE_REQUIRED, true);
};
