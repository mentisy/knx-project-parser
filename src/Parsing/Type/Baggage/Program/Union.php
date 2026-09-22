<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Union
{
    /**
     * @param int|null $sizeInBit
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Parameter>|null $parameters
     * @param \Avolle\KnxProject\Parsing\Type\Baggage\Program\Memory|null $memory
     */
    public function __construct(
        #[MapFrom('@SizeInBit')]
        public ?int $sizeInBit,

        #[MapFrom('Memory')]
        public ?Memory $memory,

        #[MapFrom('Parameter')]
        #[CastToListArray]
        #[CastListToType(Parameter::class)]
        public ?array $parameters = [],
    ) {
    }
}
