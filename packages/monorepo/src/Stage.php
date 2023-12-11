<?php declare(strict_types = 1);

namespace AloisJasa\Monorepo;

enum Stage: string
{
	case RELEASE_CANDIDATE = 'release-candidate';
	case AFTER_RELEASE_CANDIDATE = 'after-release-candidate';
	case RELEASE = 'release';
}
