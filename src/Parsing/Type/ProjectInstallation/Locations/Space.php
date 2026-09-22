<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use Avolle\KnxProject\Parsing\Type\Enum\SpaceType;
use Avolle\KnxProject\Parsing\Type\ProjectInstallation\DeviceInstanceRef;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class Space
{
    /**
     * @param string|null $id
     * @param string|null $name
     * @param \Avolle\KnxProject\Parsing\Type\Enum\SpaceType|string|null $type
     * @param string|null $usage
     * @param string|int|null $number
     * @param string|null $comment
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $defaultLine
     * @param string|null $description
     * @param int|null $puId
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations\Space>|null $spaces
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\DeviceInstanceRef>|null $deviceInstanceRefs
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations\SpaceFunction>|null $functions
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public ?string $name,

        #[MapFrom('@Type')]
        #[CastToEnum(SpaceType::Building)]
        public SpaceType|string|null $type,

        #[MapFrom('@Usage')]
        public ?string $usage,

        #[MapFrom('@Number')]
        public string|int|null $number,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@DefaultLine')]
        public ?string $defaultLine,

        #[MapFrom('@Description')]
        #[CastToType('string')]
        public ?string $description,

        #[MapFrom('@Puid')]
        public ?int $puId,

        #[MapFrom('Space')]
        #[CastToListArray]
        #[CastListToType(Space::class)]
        public ?array $spaces = [],

        #[MapFrom('DeviceInstanceRef')]
        #[CastToListArray]
        #[CastListToType(DeviceInstanceRef::class)]
        public ?array $deviceInstanceRefs = [],

        #[MapFrom('Function')]
        #[CastToListArray]
        #[CastListToType(SpaceFunction::class)]
        public ?array $functions = [],
    ) {
    }
}
