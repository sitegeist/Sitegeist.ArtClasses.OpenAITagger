<?php

/*
 * This file is part of the Sitegeist.ArtClasses package.
 */

declare(strict_types=1);

namespace Sitegeist\ArtClasses\OpenAITagger\Domain;

use Neos\Flow\Annotations as Flow;

/**
 * The factory for creating OpenAI Taggers from configuration
 */
#[Flow\Scope('singleton')]
final class OpenAITaggerFactory
{
    public function create(
        string $apiToken,
    ): OpenAITagger {
        return new OpenAITagger(
            $apiToken,
        );
    }
}
