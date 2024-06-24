<?php

declare(strict_types=1);

namespace Retailcrm\AutoMapperBundle\Tests\Fixtures;

/**
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class DestinationPost
{
    /** @param DestinationComment[] $comments */
    public function __construct(
        public ?string $title = null,
        public ?string $description = null,
        public mixed $author = null,
        public ?array $comments = null,
    ) {
    }

    public static function default(): self
    {
        /** @var DestinationComment[] $comments */
        $comments = [];
        for ($i = 0; $i < 5; ++$i) {
            $comments[] = new DestinationComment('Comment content' . $i);
        }

        return new self(
            'Comment name',
            'Comment description',
            'John',
            $comments
        );
    }
}
