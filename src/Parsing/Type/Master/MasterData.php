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
class MasterData
{
    /**
     * @param string $id
     * @param int $version
     * @param string $signature
     * @param array<\Avolle\KnxProject\Parsing\Type\Master\DatapointType> $datapointTypes
     * @param array<\Avolle\KnxProject\Parsing\Type\Master\MediumType> $mediumTypes
     * @param array<\Avolle\KnxProject\Parsing\Type\Master\Manufacturer> $manufacturers
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Version')]
        public int $version,

        #[MapFrom('@Signature')]
        public string $signature,

        #[MapFrom('DatapointTypes')]
        #[CastExtractFromArrayKey('DatapointType')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(DatapointType::class)]
        public array $datapointTypes,

        #[MapFrom('MediumTypes')]
        #[CastExtractFromArrayKey('MediumType')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(MediumType::class)]
        public array $mediumTypes,

        #[MapFrom('Manufacturers')]
        #[CastExtractFromArrayKey('Manufacturer')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Manufacturer::class)]
        public array $manufacturers,
    ) {
    }
}
