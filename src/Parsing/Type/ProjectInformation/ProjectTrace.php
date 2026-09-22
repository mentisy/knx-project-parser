<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInformation;

use DateTimeImmutable;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;

/**
 * @internal
 */
class ProjectTrace
{
    /**
     * @param \DateTimeImmutable $date
     * @param string $userName
     * @param string $comment
     */
    public function __construct(
        #[MapFrom('@Date')]
        #[CastToDateTimeImmutable]
        public DateTimeImmutable $date,

        #[MapFrom('@UserName')]
        public string $userName,

        #[MapFrom('@Comment')]
        public string $comment,
    ) {
    }
}
