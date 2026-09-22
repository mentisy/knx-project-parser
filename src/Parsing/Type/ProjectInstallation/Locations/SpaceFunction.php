<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class SpaceFunction
{
    /**
     * @param string $id
     * @param string $name
     * @param string $type
     * @param string|null $implements
     * @param string|int|null $number
     * @param string|null $comment
     * @param string|null $description
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $defaultGroupRange
     * @param int $puId
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Locations\GroupAddressRef>|null $groupAddressRefs
     */
    public function __construct(
        #[MapFrom('@Id')]
        public string $id,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public string $name,

        #[MapFrom('@Type')]
        public string $type,

        #[MapFrom('@Implements')]
        public ?string $implements,

        #[MapFrom('@Number')]
        public string|int|null $number,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@Description')]
        public ?string $description,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@DefaultGroupRange')]
        public ?string $defaultGroupRange,

        #[MapFrom('@Puid')]
        public int $puId,

        #[MapFrom('GroupAddressRef')]
        #[CastToListArray]
        #[CastListToType(GroupAddressRef::class)]
        public ?array $groupAddressRefs,
    ) {
    }
}
