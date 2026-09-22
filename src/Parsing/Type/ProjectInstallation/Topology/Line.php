<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance;
use Avolle\KnxProject\ProjectArchive\KnxContainer;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class Line
{
    /**
     * @param string $id
     * @param string|null $name
     * @param int $address
     * @param string|null $comment
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $description
     * @param int|null $puId
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Segment>|null $segments
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Topology\Device\DeviceInstance>|null $devices
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public ?string $name,

        #[MapFrom('@Address')]
        public int $address,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@Puid')]
        public ?int $puId,

        #[MapFrom('Segment')]
        #[CastToListArray]
        #[CastListToType(Segment::class)]
        public ?array $segments, // When >= ETS 6

        #[MapFrom('DeviceInstance')]
        #[CastToListArray]
        #[CastListToType(DeviceInstance::class)]
        public ?array $devices, // When <= ETS 5
    ) {
    }

    /**
     * Determined whether the project uses segments. Segments are only in ETS versions >= 6.0
     *
     * @return bool
     */
    public function usesSegments(): bool
    {
        $knx = KnxContainer::getKnxInstallation();

        return $knx->isEts6();
    }
}
