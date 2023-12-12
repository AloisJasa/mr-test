<?php declare(strict_types=1);

use Symplify\MonorepoBuilder\Config\MBConfig;

return static function (MBConfig $containerConfigurator): void {
	$services = $containerConfigurator->services();
	$services->set(\AloisJasa\Monorepo\Worker\Release\EmptyReleaseWorker::class);
};
