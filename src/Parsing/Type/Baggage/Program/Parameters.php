<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class Parameters
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Parameter>|null $parameters
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Union>|null $unions
     */
    public function __construct(
        #[MapFrom('Parameter')]
        #[CastToArrayValues]
        #[CastToListArray]
        #[CastListToType(Parameter::class)]
        public ?array $parameters = [],

        #[MapFrom('Union')]
        #[CastToListArray]
        #[CastListToType(Union::class)]
        public ?array $unions = [],
    ) {
    }
}
