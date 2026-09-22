<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use DateTimeImmutable;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;

/**
 * @internal
 */
class HistoryEntry
{
    /**
     * @param \DateTimeImmutable $date
     * @param string|null $user
     * @param string $text
     * @param string|null $detail
     */
    public function __construct(
        #[MapFrom('@Date')]
        #[CastToDateTimeImmutable]
        public DateTimeImmutable $date,

        #[MapFrom('@User')]
        public ?string $user,

        #[MapFrom('@Text')]
        public string $text,

        #[MapFrom('@Detail')]
        public ?string $detail,
    ) {
    }
}
