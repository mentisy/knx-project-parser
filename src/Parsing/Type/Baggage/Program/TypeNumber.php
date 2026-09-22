<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use EventSauce\ObjectHydrator\MapFrom;

/**
 * @internal
 */
class TypeNumber
{
    public function __construct(
        #[MapFrom('@SizeInBit')]
        public ?int $sizeInBit,

        #[MapFrom('@Type')]
        public ?string $type,

        #[MapFrom('@minInclusive')] // Lower-case is intentional
        public ?int $minInclusive,

        #[MapFrom('@maxInclusive')] // Lower-case is intentional
        public ?int $maxInclusive,
    ) {
    }
}
