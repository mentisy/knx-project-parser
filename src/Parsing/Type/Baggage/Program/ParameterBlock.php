<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class ParameterBlock
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param string|null $text
     * @param string|null $paramRefId
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\ParameterRefRef> $parameterRefRefs
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Choose> $chooses
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Text')]
        public ?string $text,

        #[MapFrom('@ParamRefId')]
        public ?string $paramRefId,

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
    ) {
    }
}
