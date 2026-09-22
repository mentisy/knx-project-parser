<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class ChannelIndependantBlock
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterBlock> $parameterBlocks
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Choose> $chooses
     */
    public function __construct(
        #[MapFrom('ParameterBlock')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(ParameterBlock::class)]
        public array $parameterBlocks = [],

        #[MapFrom('choose')] // Lower-case choose is intentional, since XML is lower-case.
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Choose::class)]
        public array $chooses = [],
    ) {
    }
}
