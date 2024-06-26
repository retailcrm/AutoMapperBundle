<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

/**
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class SourcePost
{
    /** @param SourceComment[] $comments */
    public function __construct(
        public ?string $name = null,
        public ?string $description = null,
        public mixed $author = null,
        public ?array $comments = null,
    ) {
    }

    public static function default(): self
    {
        $comments = [];
        for ($i = 0; $i < 5; ++$i) {
            $comments[] = new SourceComment('Comment content' . $i);
        }

        return new self(
            'Comment name',
            'Comment description',
            SourceAuthor::default(),
            $comments
        );
    }
}
