<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class ManufacturerData
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Hardware\Manufacturer>|null $manufacturers
     */
    public function __construct(
        #[MapFrom('Manufacturer')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Manufacturer::class)]
        public ?array $manufacturers = [],
    ) {
    }

    public function findManufacturer(string $manufacturerId): ?Manufacturer
    {
        foreach ($this->manufacturers as $manufacturer) {
            if ($manufacturer->refId === $manufacturerId) {
                return $manufacturer;
            }
        }

        return null;
    }
}
