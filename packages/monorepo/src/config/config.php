<?php declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$containerConfigurator->import(__DIR__ . '/open-dev.php');
	$containerConfigurator->import(__DIR__ . '/release-candidate.php');
	$containerConfigurator->import(__DIR__ . '/release.php');

	$parameters = $containerConfigurator->parameters();
	$parameters->set('enable_default_release_workers', false);

	// require "--stage <name>" when release command is run
	$parameters->set('is_stage_required', true);
};
