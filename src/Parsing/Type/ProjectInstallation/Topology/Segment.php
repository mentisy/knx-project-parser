<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;

/**
 * @internal
 */
class Segment
{
    /**
     * @param string $id
     * @param string|null $name
     * @param int $number
     * @param string|null $comment
     * @param string $mediumTypeRefId
     * @param int|null $domainAddress
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $description
     * @param int $puId
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance>|null $devices
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Name')]
        public ?string $name,

        #[MapFrom('@Number')]
        public int $number,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@MediumTypeRefId')]
        public string $mediumTypeRefId,

        #[MapFrom('@DomainAddress')]
        public ?int $domainAddress,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@Puid')]
        public int $puId,

        #[MapFrom('DeviceInstance')]
        #[CastToListArray]
        #[CastListToType(DeviceInstance::class)]
        public ?array $devices,
    ) {
    }
}
