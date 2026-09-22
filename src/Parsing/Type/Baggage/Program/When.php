<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToBool;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class When
{
    /**
     * @param string|int|null $test
     * @param bool|null $default
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ComObjectRefRef> $comObjectRefRefs
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterRefRef> $parameterRefRefs
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Choose> $chooses
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterBlock> $parameterBlocks
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Channel> $channels
     */
    public function __construct(
        #[MapFrom('@test')]
        public string|int|null $test,

        #[MapFrom('@default')]
        #[CastToBool(true)]
        public ?bool $default,

        #[MapFrom('ComObjectRefRef')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(ComObjectRefRef::class)]
        public array $comObjectRefRefs = [],

        #[MapFrom('ParameterRefRef')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(ParameterRefRef::class)]
        public array $parameterRefRefs = [],

        #[MapFrom('choose')] // Lower-case choose is intentional, since XML is lower-case.
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Choose::class)]
        public array $chooses = [],

        #[MapFrom('ParameterBlock')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(ParameterBlock::class)]
        public array $parameterBlocks = [],

        #[MapFrom('Channel')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Channel::class)]
        public array $channels = [],
    ) {
    }
}
