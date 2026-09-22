<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology;

use Avolle\KnxProject\Parsing\Caster\CastExtractFromArrayKey;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Topology
{
    /**
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Area>|null $areas
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance>|null $unassignedDevices
     */
    public function __construct(
        #[MapFrom('Area')]
        #[CastToListArray]
        #[CastListToType(Area::class)]
        public ?array $areas,

        #[MapFrom('UnassignedDevices')]
        #[CastExtractFromArrayKey('DeviceInstance')]
        #[CastToListArray]
        #[CastListToType(DeviceInstance::class)]
        public ?array $unassignedDevices = [],
    ) {
    }

    /**
     * Find device based on EITHER `$fullAddress` or `$deviceRefId´. Use named arguments to use whichever reference
     * is desired to search devices by.
     *
     * @param string|null $fullAddress Full address, separated by periods (1.1.1)
     * @param string|null $deviceRefId Reference id found in internal project files.
     * @return \Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance|null
     */
    public function findDevice(?string $fullAddress = null, ?string $deviceRefId = null): ?DeviceInstance
    {
        // Find by full address
        if ($fullAddress !== null) {
            $addressParts = explode('.', $fullAddress);
            foreach ($this->areas as $area) {
                if ($area->address !== (int)$addressParts[0]) {
                    continue;
                }
                foreach ($area->lines as $line) {
                    if ($line->address !== (int)$addressParts[1]) {
                        continue;
                    }
                    if ($line->usesSegments()) {
                        foreach ($line->segments as $segment) {
                            foreach ($segment->devices as $device) {
                                if ($device->address === (int)$addressParts[2]) {
                                    return $device;
                                }
                            }
                        }
                    } else {
                        foreach ($line->devices as $device) {
                            if ($device->address === (int)$addressParts[2]) {
                                return $device;
                            }
                        }
                    }
                }
            }

            return null;
        }
        // Find by device ref id
        if ($deviceRefId !== null) {
            die('not implemented yet');
        }

        return null;
    }
}
