<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device;

use DateTimeImmutable;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastToDateTimeImmutable;

/**
 * @internal
 */
class Security
{
    public function __construct(
        #[MapFrom('@LoadedIPRoutingBackboneKey')]
        public ?string $loadedIpRoutingBackboneKey,

        #[MapFrom('@DeviceAuthenticationCode')]
        public ?string $deviceAuthenticationCode,

        #[MapFrom('@DeviceAuthenticationCodeHash')]
        public ?string $deviceAuthenticationCodeHash,

        #[MapFrom('@LoadedDeviceAuthenticationCodeHash')]
        public ?string $loadedDeviceAuthenticationCodeHash,

        #[MapFrom('@DeviceManagementPassword')]
        public ?string $deviceManagementPassword,

        #[MapFrom('@DeviceManagementPasswordHash')]
        public ?string $deviceManagementPasswordHash,

        #[MapFrom('@LoadedDeviceManagementPasswordHash')]
        public ?string $loadedDeviceManagementPasswordHash,

        #[MapFrom('@ToolKey')]
        public ?string $toolKey,

        #[MapFrom('@LoadedToolKey')]
        public ?string $loadedToolKey,

        #[MapFrom('@SequenceNumber')]
        public ?int $sequenceNumber,

        #[MapFrom('@SequenceNumberTimestamp')]
        #[CastToDateTimeImmutable]
        public ?DateTimeImmutable $sequenceNumberTimestamp,

        #[MapFrom('@UnicastBroadcastBlocking')]
        public ?string $unicastBroadcastBlocking,
    ) {
    }
}
