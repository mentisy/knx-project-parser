<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class Choose
{
    /**
     * @param string|null $paramRefId
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\When> $whens
     */
    public function __construct(
        #[MapFrom('@ParamRefId')]
        public ?string $paramRefId,

        #[MapFrom('when')] // Lower-case choose is intentional, since XML is lower-case.
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(When::class)]
        public array $whens = [],
    ) {
    }
}
