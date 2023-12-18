<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo;

enum Stage: string
{
	case RELEASE_CANDIDATE = 'release-candidate';
	case OPEN_DEV = 'open-dev';
	case RELEASE = 'release';
	case PATCH = 'patch';
}
