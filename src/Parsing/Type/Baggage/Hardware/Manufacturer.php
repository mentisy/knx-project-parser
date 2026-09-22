<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\Baggage\Hardware;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToArrayValues;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Manufacturer
{
    /**
     * @param string|null $refId
     * @param array<\Avolle\KnxProject\Parsing\Type\Baggage\Hardware\Hardware>|null $hardware
     */
    public function __construct(
        #[MapFrom('@RefId')]
        public ?string $refId,

        #[MapFrom('Hardware')]
        #[CastExtractFromArrayKey('Hardware')]
        #[CastToListArray]
        #[CastToArrayValues]
        #[CastListToType(Hardware::class)]
        public ?array $hardware = [],
    ) {
    }

    public function findHardware(string $hardwareId): ?Hardware
    {
        foreach ($this->hardware as $hardware) {
            if ($hardware->id === $hardwareId) {
                return $hardware;
            }
        }

        return null;
    }
}
