<?php
declare(strict_types=1);

namespace Avolle\KnxProject\Parsing\Type\ProjectInstallation;

use Avolle\KnxProject\Parsing\Caster\CastToEnum;
use Avolle\KnxProject\Parsing\Caster\CastToListArray;
use Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus;
use EventSauce\ObjectHydrator\MapFrom;
use EventSauce\ObjectHydrator\PropertyCasters\CastListToType;
use EventSauce\ObjectHydrator\PropertyCasters\CastToType;

/**
 * @internal
 */
class Trade
{
    /**
     * @param string|null $id
     * @param string $name
     * @param string|null $number
     * @param string|null $comment
     * @param \Avolle\KnxProject\Parsing\Type\Enum\CompletionStatus|string|null $completionStatus
     * @param string|null $description
     * @param int $puId
     * @param array<\Avolle\KnxProject\Parsing\Type\ProjectInstallation\Trade>|null $trades
     * @param array<DeviceInstanceRef>|null $deviceInstanceRefs
     */
    public function __construct(
        #[MapFrom('@Id')]
        public ?string $id,

        #[MapFrom('@Name')]
        #[CastToType('string')]
        public string $name,

        #[MapFrom('@Number')]
        public ?string $number,

        #[MapFrom('@Comment')]
        public ?string $comment,

        #[MapFrom('@CompletionStatus')]
        #[CastToEnum(CompletionStatus::Unknown)]
        public CompletionStatus|string|null $completionStatus,

        #[MapFrom('@Description')]
        #[CastToType('string')]
        public ?string $description,

        #[MapFrom('@Puid')]
        public int $puId,

        #[MapFrom('Trade')]
        #[CastToListArray]
        #[CastListToType(Trade::class)]
        public ?array $trades = [],

        #[MapFrom('DeviceInstanceRef')]
        #[CastToListArray]
        #[CastListToType(DeviceInstanceRef::class)]
        public ?array $deviceInstanceRefs = [],
    ) {
    }
}
