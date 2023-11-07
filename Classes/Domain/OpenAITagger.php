<?php

/*
 * This file is part of the Sitegeist.ArtClasses package.
 */

declare(strict_types=1);

namespace Sitegeist\ArtClasses\OpenAITagger\Domain;

use Sitegeist\ArtClasses\Domain\Tagging\ObjectTaggerInterface;

/**
 * An Azure Computer Vision based interpreter
 */
final class OpenAITagger implements ObjectTaggerInterface
{
    public function __construct(
        private readonly string $apiToken
    ) {
    }

    /**
     * @param array<string> $interpretedTags
     * @param array<string> $availableTags
     * @return array<string>
     */
    public function tagObject(array $interpretedTags, array $availableTags): array
    {
        $client = \OpenAI::client($this->apiToken);
        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Provide only a comma-separated list of elements in list '
                        . '"' . implode(',', $availableTags) . ',"'
                        . 'that match one of the terms in list '
                        . '"' . implode(',', $interpretedTags) . ',"'
                ],
            ],
        ]);

        return array_filter(array_map(
            fn (string $match): ?string => in_array($match, $availableTags) ? $match : null,
            explode("\n", $response->choices[0]->message->content)
        ));
    }
}
