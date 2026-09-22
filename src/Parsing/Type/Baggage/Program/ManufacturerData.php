<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Program;

use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

class ManufacturerData
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Program\Manufacturer>|null $manufacturers
     */
    public function __construct(
        #[MapFrom('Manufacturer')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Manufacturer::class)]
        public ?array $manufacturers = [],
    ) {
    }

    /**
     * @param string $manufacturerId
     * @param bool|null $throw
     * @return \Avolle\KnxProject\Parsing\Type\Baggage\Program\Manufacturer|null
     * @throws \Avolle\KnxProject\Service\DeviceInconsistencyFixer\ValueExtractionException
     */
    public function findManufacturer(string $manufacturerId, ?bool $throw = true): ?Manufacturer
    {
        foreach ($this->manufacturers as $manufacturer) {
            if ($manufacturer->refId === $manufacturerId) {
                return $manufacturer;
            }
        }
        if ($throw) {
            throw new ValueExtractionException(
                sprintf('Could not extract `%s` based on %s`: %s`', 'manufacturer', 'manufacturerId', $manufacturerId),
            );
        }

        return null;
    }
}
