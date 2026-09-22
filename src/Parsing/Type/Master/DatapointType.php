<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Master;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class DatapointType
{
    /**
     * @param string $id
     * @param int $number
     * @param string $name
     * @param string|null $text
     * @param int|null $sizeInBit
     * @param string|null $pdt
     * @param array<\Avolle\KnxProject\Parsing\Type\Master\DatapointSubType> $datapointSubTypes
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Number')]
        public int $number,

        #[MapFrom('@Name')]
        public string $name,

        #[MapFrom('@Text')]
        public ?string $text,

        #[MapFrom('@SizeInBit')]
        public ?int $sizeInBit,

        #[MapFrom('@PDT')]
        public ?string $pdt,

        #[MapFrom('DatapointSubtypes')]
        #[CastExtractFromArrayKey('DatapointSubtype')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(DatapointSubType::class)]
        public array $datapointSubTypes,
    ) {
    }
}
